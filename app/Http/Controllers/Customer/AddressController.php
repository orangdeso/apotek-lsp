<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of user addresses
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return view('customer.address.index', compact('addresses'));
    }



    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
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
            $address = new Address($request->all());
            $address->user_id = Auth::id();
            $address->save();

            // If this is set as default, update other addresses
            if ($request->is_default) {
                $address->setAsDefault();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully!',
                    'address' => $address
                ]);
            }

            return redirect()->route('customer.addresses.index')
                ->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save address: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Failed to save address')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified address
     */
    public function edit($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('customer.address.edit', compact('address'));
    }

    /**
     * Update the specified address
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
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
            $address = Auth::user()->addresses()->findOrFail($id);
            $address->update($request->all());

            // If this is set as default, update other addresses
            if ($request->is_default) {
                $address->setAsDefault();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address updated successfully!',
                    'address' => $address
                ]);
            }

            return redirect()->route('customer.addresses.index')
                ->with('success', 'Address updated successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update address: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Failed to update address')
                ->withInput();
        }
    }

    /**
     * Remove the specified address
     */
    public function destroy($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        
        // Don't allow deletion if it's the only address
        if (Auth::user()->addresses()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the only address. Please add another address first.'
            ], 400);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!'
        ]);
    }

    /**
     * Set address as default
     */
    public function setDefault($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->setAsDefault();

        return response()->json([
            'success' => true,
            'message' => 'Default address updated successfully!'
        ]);
    }

    /**
     * Get addresses for AJAX requests (for checkout)
     */
    public function getAddresses()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }
}