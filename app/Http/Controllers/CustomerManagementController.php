<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManagementController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = User::where('role', 'pelanggan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.user.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.user.customer.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telpon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
            'telpon' => $request->telpon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit($id)
    {
        $customer = User::where('role', 'pelanggan')->findOrFail($id);
        return view('admin.user.customer.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = User::where('role', 'pelanggan')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'telpon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'kota' => 'required|string|max:255',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'telpon' => $request->telpon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $customer->update($updateData);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = User::where('role', 'pelanggan')->findOrFail($id);
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus.'
        ]);
    }
}