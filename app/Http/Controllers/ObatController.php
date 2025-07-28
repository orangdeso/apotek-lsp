<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ObatController extends Controller
{
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

        return redirect()->route('pharmacist.obat.index')
                        ->with('success', 'Obat berhasil ditambahkan.');
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

        return redirect()->route('pharmacist.obat.index')
                        ->with('success', 'Obat berhasil diperbarui.');
    }
}