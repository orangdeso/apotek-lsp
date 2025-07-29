<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    /**
     * Display a listing of drugs for admin
     */
    public function index()
    {
        $obats = Obat::with('supplier')->latest()->paginate(10);
        $suppliers = Supplier::all(); // Add suppliers for edit modal
        return view('admin.drugs.index', compact('obats', 'suppliers'));
    }

    /**
     * Show the form for creating a new drug
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('admin.drugs.create', compact('suppliers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_obat' => 'required|string|max:255',
            'type' => 'required|string',
            'unit' => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expdate' => 'required|date|after:today',
            'id_supplier' => 'required|exists:supplier,id_supplier'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name_obat) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('obat-images', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        Obat::create($data);

        // Redirect based on user role
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.drugs.index')
                            ->with('success', 'Obat berhasil ditambahkan.');
        } else {
            return redirect()->route('pharmacist.obat.index')
                            ->with('success', 'Obat berhasil ditambahkan.');
        }
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        
        $request->validate([
            'name_obat' => 'required|string|max:255',
            'type' => 'required|string',
            'unit' => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expdate' => 'required|date|after:today',
            'id_supplier' => 'required|exists:supplier,id_supplier'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($obat->image && Storage::disk('public')->exists($obat->image)) {
                Storage::disk('public')->delete($obat->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name_obat) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('obat-images', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $obat->update($data);

        // Redirect based on user role
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.drugs.index')
                            ->with('success', 'Obat berhasil diperbarui.');
        } else {
            return redirect()->route('pharmacist.obat.index')
                            ->with('success', 'Obat berhasil diperbarui.');
        }
    }

    /**
     * Show the form for editing the specified drug
     */
    public function edit($id)
    {
        $obat = Obat::with('supplier')->findOrFail($id);
        $suppliers = Supplier::all();
        
        // If request expects JSON (for AJAX), return JSON response
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'drug' => $obat,
                'suppliers' => $suppliers
            ]);
        }
        
        // Otherwise return view (for future use)
        return view('admin.drugs.edit', compact('obat', 'suppliers'));
    }

    /**
     * Remove the specified drug from storage
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        
        // Delete image if exists
        if ($obat->image && Storage::disk('public')->exists($obat->image)) {
            Storage::disk('public')->delete($obat->image);
        }
        
        $obat->delete();
        
        // Redirect based on user role
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.drugs.index')
                            ->with('success', 'Obat berhasil dihapus.');
        } else {
            return redirect()->route('pharmacist.obat.index')
                            ->with('success', 'Obat berhasil dihapus.');
        }
    }
}