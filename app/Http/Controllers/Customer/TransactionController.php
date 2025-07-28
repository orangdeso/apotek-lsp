<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Process checkout and create transaction
     */
    public function processCheckout(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'address_id' => 'required|exists:addresses,id',
                'payment_method' => 'required|in:cod,transfer',
                'notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Start database transaction
            DB::beginTransaction();

            // Get user and verify address ownership
            $user = Auth::user();
            $address = $user->addresses()->findOrFail($request->address_id);

            // Get cart items from database
            $cartItems = Cart::with('obat')
                            ->where('user_id', $user->id)
                            ->get();

            if ($cartItems->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            // Calculate total and prepare order details
            $total = 0;
            $orderDetails = [];

            foreach ($cartItems as $cartItem) {
                $obat = $cartItem->obat;
                
                // Check stock availability
                if ($obat->stok < $cartItem->quantity) {
                    throw new \Exception("Insufficient stock for {$obat->name_obat}. Available: {$obat->stok}, Requested: {$cartItem->quantity}");
                }

                $subtotal = $cartItem->quantity * $cartItem->price;
                $total += $subtotal;

                $orderDetails[] = [
                    'id_obat' => $cartItem->id_obat,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'subtotal' => $subtotal
                ];
            }

            // Create penjualan record
            $penjualan = Penjualan::create([
                'id_user' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'address_id' => $address->id
            ]);

            // Create penjualan details and update stock
            foreach ($orderDetails as $detail) {
                // Create detail record
                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_obat' => $detail['id_obat'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'subtotal' => $detail['subtotal']
                ]);

                // Update stock
                $obat = Obat::find($detail['id_obat']);
                $obat->decrement('stok', $detail['quantity']);
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            // Commit transaction
            DB::commit();

            // Log successful transaction
            Log::info('Transaction created successfully', [
                'user_id' => $user->id,
                'penjualan_id' => $penjualan->id_penjualan,
                'total' => $total
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $penjualan->id_penjualan,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollback();

            // Log error
            Log::error('Transaction failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show order confirmation page
     */
    public function confirmation($id)
    {
        try {
            $penjualan = Penjualan::with(['user', 'penjualanDetails.obat'])
                ->where('id_penjualan', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            return view('customer.order.confirmation', compact('penjualan'));
        } catch (\Exception $e) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Order not found or access denied.');
        }
    }

    /**
     * Show order history
     */
    public function history()
    {
        $penjualans = Penjualan::with(['penjualanDetails.obat'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.order.history', compact('penjualans'));
    }

    /**
     * Show order detail
     */
    public function show($id)
    {
        try {
            $penjualan = Penjualan::with(['user', 'penjualanDetails.obat'])
                ->where('id_penjualan', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            return view('customer.order.detail', compact('penjualan'));
        } catch (\Exception $e) {
            return redirect()->route('customer.orders.history')
                ->with('error', 'Order not found or access denied.');
        }
    }

    /**
     * Cancel order (if status is pending)
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $penjualan = Penjualan::with('penjualanDetails.obat')
                ->where('id_penjualan', $id)
                ->where('id_user', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            // Restore stock for each item
            foreach ($penjualan->penjualanDetails as $detail) {
                $detail->obat->increment('stok', $detail->quantity);
            }

            // Update order status
            $penjualan->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order status for AJAX requests
     */
    public function getOrderStatus($id)
    {
        try {
            $penjualan = Penjualan::where('id_penjualan', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'status' => $penjualan->status,
                'updated_at' => $penjualan->updated_at->format('d M Y, H:i')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
    }
}