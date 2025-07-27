<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display customer dashboard with products
     */
    public function dashboard()
    {
        // Ambil obat yang tersedia (stok > 0 dan belum expired)
        $obats = Obat::with('supplier')
            ->where('stok', '>', 0)
            ->where('expdate', '>', now())
            ->orderBy('created_at', 'desc')
            ->take(12) // Tampilkan 12 produk terbaru
            ->get();
            
        // Statistik untuk dashboard
        $totalObat = Obat::where('stok', '>', 0)->count();
        $kategoriObat = Obat::distinct('type')->count('type');
        
        return view('dashboard.customer', compact('obats', 'totalObat', 'kategoriObat'));
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
}