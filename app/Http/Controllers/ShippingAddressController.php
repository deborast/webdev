<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();

        return view('shipping.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:30',
            'address_line' => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'province'     => 'required|string|max:100',
            'postal_code'  => 'required|string|max:20',
            'country'      => 'required|string|max:100',
        ]);

        ShippingAddress::create([
            'user_id'      => Auth::id(),
            'full_name'    => $data['full_name'],
            'phone'        => $data['phone'],
            'address_line' => $data['address_line'],
            'city'         => $data['city'],
            'province'     => $data['province'],
            'postal_code'  => $data['postal_code'],
            'country'      => $data['country'],
        ]);

        return redirect()->route('shipping.index')
            ->with('success', 'Address added successfully!');
    }

    public function destroy(ShippingAddress $shipping)
    {
        if ($shipping->user_id !== Auth::id()) {
            abort(403);
        }

        $shipping->delete();

        return redirect()->route('shipping.index')
            ->with('success', 'Address removed.');
    }
}
