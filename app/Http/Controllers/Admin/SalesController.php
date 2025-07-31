<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display all sales transactions
     */
    public function index()
    {
        $penjualans = Penjualan::with(['user', 'penjualanDetails.obat'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.sales.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new sale
     */
    public function create()
    {
        $products = Obat::where('stok', '>', 0)->get()->map(function($obat) {
            return (object) [
                'id' => $obat->id_obat,
                'name_obat' => $obat->name_obat,
                'harga_jual' => $obat->sale_price,
                'stok' => $obat->stok,
                'kode_obat' => 'OBT-' . str_pad($obat->id_obat, 4, '0', STR_PAD_LEFT)
            ];
        });
        $customers = User::where('role', 'pelanggan')->get();
        
        return view('admin.sales.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created sale in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id',
            'payment_method' => 'required|in:cash,transfer,card',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.id_obat' => 'required|exists:obat,id_obat',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $total = 0;
            $orderDetails = [];

            // Validate stock and calculate total
            foreach ($request->items as $item) {
                $obat = Obat::find($item['id_obat']);
                
                if ($obat->stok < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$obat->name_obat}. Available: {$obat->stok}, Requested: {$item['quantity']}");
                }

                $subtotal = $item['quantity'] * $item['unit_price'];
                $total += $subtotal;

                $orderDetails[] = [
                    'id_obat' => $item['id_obat'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal
                ];
            }

            // Create penjualan record
            $penjualan = Penjualan::create([
                'id_user' => $request->id_user,
                'total' => $total,
                'status' => 'completed', // Admin sales are immediately completed
                'payment_method' => $request->payment_method,
                'notes' => $request->notes
            ]);

            // Create penjualan details and update stock
            foreach ($orderDetails as $detail) {
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

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale transaction created successfully!',
                'redirect' => route('admin.sales.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified sale
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'penjualanDetails.obat'])
            ->findOrFail($id);

        return view('admin.sales.show', compact('penjualan'));
    }

    /**
     * Search products for AJAX requests
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = $request->get('q', '');
            \Log::info('Search query received: ' . $query);
            
            // Pastikan menggunakan model yang benar
            $obatsQuery = \App\Models\Obat::where('stok', '>', 0);
            
            if (!empty($query)) {
                $obatsQuery->where(function($q) use ($query) {
                    $q->where('name_obat', 'LIKE', '%' . $query . '%')
                      ->orWhere('id_obat', 'LIKE', '%' . $query . '%');
                });
            }
            
            $obats = $obatsQuery->limit(20)->get();
            \Log::info('Found products: ' . $obats->count());
            
            // Transform data untuk frontend
            $transformed = $obats->map(function($obat) {
                return [
                    'id' => $obat->id_obat,
                    'name_obat' => $obat->name_obat,
                    'harga_jual' => $obat->sale_price,
                    'stok' => $obat->stok,
                    'kode_obat' => 'OBT-' . str_pad($obat->id_obat, 4, '0', STR_PAD_LEFT)
                ];
            });
            
            return response()->json($transformed);
            
        } catch (\Exception $e) {
            \Log::error('Error in searchProducts: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Get obat details for AJAX requests
     */
    public function getObatDetails($id)
    {
        $obat = Obat::find($id);
        
        if (!$obat) {
            return response()->json(['error' => 'Obat not found'], 404);
        }

        return response()->json([
            'id_obat' => $obat->id_obat,
            'name_obat' => $obat->name_obat,
            'harga_jual' => $obat->sale_price, // Use sale_price field
            'stok' => $obat->stok
        ]);
    }
}