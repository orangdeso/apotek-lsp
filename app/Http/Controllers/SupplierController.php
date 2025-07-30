<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers for admin
     */
    public function index()
    {
        $suppliers = Supplier::withCount('obats')->latest()->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created supplier in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'telpon' => 'required|string|max:20'
        ]);

        try {
            Supplier::create([
                'name_supplier' => $request->name_supplier,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->telpon
            ]);

            return redirect()->route('admin.suppliers.index')
                ->with('success', 'Supplier berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan supplier: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified supplier
     */
    public function show($id)
    {
        $supplier = Supplier::with('obats')->findOrFail($id);
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        // If request expects JSON (for AJAX), return JSON response
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'supplier' => $supplier
            ]);
        }
        
        // Otherwise return view (for future use)
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $request->validate([
            'name_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'telpon' => 'required|string|max:20'
        ]);

        try {
            $supplier->update([
                'name_supplier' => $request->name_supplier,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->telpon
            ]);

            // If AJAX request, return JSON response
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Supplier berhasil diperbarui!',
                    'supplier' => $supplier
                ]);
            }

            return redirect()->route('admin.suppliers.index')
                ->with('success', 'Supplier berhasil diperbarui!');
        } catch (\Exception $e) {
            // If AJAX request, return JSON error response
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui supplier: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui supplier: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified supplier from storage
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            
            // Check if supplier has associated drugs
            $drugCount = $supplier->obats()->count();
            
            if ($drugCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus supplier yang masih memiliki obat terkait.'
                ], 400);
            }
            
            $supplier->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus supplier: ' . $e->getMessage()
            ], 500);
        }
    }
}