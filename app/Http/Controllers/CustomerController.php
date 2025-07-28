<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display customer dashboard with products
     */
    public function dashboard()
    {
        // Ambil obat yang tersedia (stok > 0 dan belum expired)
        $obatTerbaru = Obat::with('supplier')
            ->where('stok', '>', 0)
            ->where('expdate', '>', now())
            ->orderBy('created_at', 'desc')
            ->take(12) // Tampilkan 12 produk terbaru
            ->get();
            
        // Statistik untuk dashboard
        $totalObat = Obat::where('stok', '>', 0)->count();
        $kategoriObat = Obat::distinct('type')->count('type');
        
        return view('dashboard.customer', compact('obatTerbaru', 'totalObat', 'kategoriObat'));
    }
    
    /**
     * Display all products with search and filter
     */
    public function obatIndex(Request $request)
    {
        $query = Obat::with('supplier')
            ->where('stok', '>', 0)
            ->where('expdate', '>', now());
            
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('type', 'like', '%' . $request->search . '%');
        }
        
        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        $obats = $query->paginate(12);
        $types = Obat::distinct('type')->pluck('type');
        
        return view('customer.obat.index', compact('obats', 'types'));
    }
    
    /**
     * Show product detail
     */
    public function obatShow($id)
    {
        $obat = Obat::with('supplier')->findOrFail($id);
        
        // Produk terkait (same type)
        $relatedObats = Obat::where('type', $obat->type)
            ->where('id_obat', '!=', $id)
            ->where('stok', '>', 0)
            ->take(4)
            ->get();
            
        return view('customer.obat.show', compact('obat', 'relatedObats'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, $id)
    {
        try {
            $obatId = $id;
            $obat = Obat::findOrFail($obatId);
            
            // Check if product is available
            if ($obat->stok <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock'
                ], 400);
            }

            $quantity = $request->input('quantity', 1);
            
            // Check if quantity is valid
            if ($quantity <= 0 || $quantity > $obat->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity'
                ], 400);
            }

            $userId = Auth::id();
            
            // Check if item already exists in cart
            $cartItem = Cart::where('user_id', $userId)
                           ->where('id_obat', $obatId)
                           ->first();

            if ($cartItem) {
                // Update quantity if item exists
                $newQuantity = $cartItem->quantity + $quantity;
                
                if ($newQuantity > $obat->stok) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available'
                    ], 400);
                }
                
                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $obat->sale_price // Update price in case it changed
                ]);
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => $userId,
                    'id_obat' => $obatId,
                    'quantity' => $quantity,
                    'price' => $obat->sale_price
                ]);
            }

            $totalItems = Cart::getTotalItemsForUser($userId);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'total_items' => $totalItems
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to cart'
            ], 500);
        }
    }

    /**
     * View cart
     */
    public function viewCart()
    {
        $cartItems = Cart::with('obat')
                        ->where('user_id', Auth::id())
                        ->get();

        $totalPrice = Cart::getTotalPriceForUser(Auth::id());
        $totalItems = Cart::getTotalItemsForUser(Auth::id());

        return view('customer.cart.index', compact('cartItems', 'totalPrice', 'totalItems'));
    }

    /**
     * Update cart item quantity
     */
    public function updateCartItem(Request $request, $cartId)
    {
        try {
            $cartItem = Cart::where('id_cart', $cartId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

            $quantity = $request->input('quantity');
            
            if ($quantity <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity'
                ], 400);
            }

            // Check stock availability
            if ($quantity > $cartItem->obat->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $cartItem->update(['quantity' => $quantity]);

            $totalPrice = Cart::getTotalPriceForUser(Auth::id());
            $totalItems = Cart::getTotalItemsForUser(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'subtotal' => $cartItem->subtotal,
                'total_price' => $totalPrice,
                'total_items' => $totalItems
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating cart'
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($cartId)
    {
        try {
            $cartItem = Cart::where('id_cart', $cartId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

            $cartItem->delete();

            $totalPrice = Cart::getTotalPriceForUser(Auth::id());
            $totalItems = Cart::getTotalItemsForUser(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'total_price' => $totalPrice,
                'total_items' => $totalItems
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing item'
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        try {
            Cart::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while clearing cart'
            ], 500);
        }
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = Cart::with('obat')
                        ->where('user_id', Auth::id())
                        ->get();

        if ($cartItems->count() === 0) {
            return redirect()->route('customer.cart.view')
                           ->with('error', 'Your cart is empty');
        }

        // Get user addresses
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        
        // If user has no addresses, redirect to address management
        if ($addresses->count() === 0) {
            return redirect()->route('customer.addresses.index')
                           ->with('info', 'Please add a delivery address before checkout');
        }

        $totalPrice = Cart::getTotalPriceForUser(Auth::id());
        $totalItems = Cart::getTotalItemsForUser(Auth::id());

        return view('customer.checkout.index', compact('cartItems', 'totalPrice', 'totalItems', 'addresses'));
    }

    /**
     * Get cart count for AJAX requests
     */
    public function getCartCount()
    {
        try {
            $count = Cart::getTotalItemsForUser(Auth::id());
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cart count'
            ], 500);
        }
    }
}