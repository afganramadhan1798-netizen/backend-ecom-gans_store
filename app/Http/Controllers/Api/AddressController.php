<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Mengambil alamat user yang sedang login
    public function index(Request $request)
    {
        $address = $request->user()->address;

        return response()->json([
            'address' => $address,
        ]);
    }

    // Menyimpan atau memperbarui alamat user
    public function update(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'address_detail' => 'required|string',
        ]);

        $address = $request->user()
            ->address()
            ->updateOrCreate([], $validated);

        return response()->json([
            'message' => 'Alamat berhasil disimpan.',
            'address' => $address,
        ]);
    }
}
