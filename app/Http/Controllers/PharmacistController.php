<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PharmacistController extends Controller
{
    /**
     * Display a listing of pharmacists for admin
     */
    public function index()
    {
        $pharmacists = User::where('role', 'apoteker')
            ->latest()
            ->paginate(10);
        return view('admin.user.pharmacist.index', compact('pharmacists'));
    }

    /**
     * Show the form for creating a new pharmacist
     */
    public function create()
    {
        return view('admin.user.pharmacist.create');
    }

    /**
     * Store a newly created pharmacist in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'telpon' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'alamat.required' => 'Alamat wajib diisi',
            'kota.required' => 'Kota wajib diisi',
            'telpon.required' => 'Nomor telepon wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->telpon,
                'role' => 'apoteker',
            ]);

            return redirect()->route('admin.pharmacists.index')
                ->with('success', 'Apoteker berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan apoteker: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified pharmacist
     */
    public function show($id)
    {
        $pharmacist = User::where('role', 'apoteker')->findOrFail($id);
        return view('admin.user.pharmacist.show', compact('pharmacist'));
    }

    /**
     * Show the form for editing the specified pharmacist
     */
    public function edit($id)
    {
        $pharmacist = User::where('role', 'apoteker')->findOrFail($id);
        
        // If request expects JSON (for AJAX), return JSON response
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'pharmacist' => $pharmacist
            ]);
        }
        
        // Otherwise return view
        return view('admin.user.pharmacist.edit', compact('pharmacist'));
    }

    /**
     * Update the specified pharmacist in storage
     */
    public function update(Request $request, $id)
    {
        $pharmacist = User::where('role', 'apoteker')->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($pharmacist->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'telpon' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'alamat.required' => 'Alamat wajib diisi',
            'kota.required' => 'Kota wajib diisi',
            'telpon.required' => 'Nomor telepon wajib diisi',
        ]);

        if ($validator->fails()) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'telpon' => $request->telpon,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $pharmacist->update($updateData);

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Apoteker berhasil diperbarui!',
                    'pharmacist' => $pharmacist->fresh()
                ]);
            }

            return redirect()->route('admin.pharmacists.index')
                ->with('success', 'Apoteker berhasil diperbarui!');
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui apoteker: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Gagal memperbarui apoteker: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified pharmacist from storage
     */
    public function destroy($id)
    {
        try {
            $pharmacist = User::where('role', 'apoteker')->findOrFail($id);
            
            // Check if pharmacist has any related data (transactions, etc.)
            // Add additional checks here if needed
            
            $pharmacist->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Apoteker berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus apoteker: ' . $e->getMessage()
            ], 500);
        }
    }
}