<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Mengambil Wishlist pengguna yang sedang login
    public function index(Request $request)
    {
        $wishlists = $request->user()
            ->wishlists()
            ->with('product')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'wishlists' => $wishlists,
        ]);
    }

    // Menambahkan produk ke Wishlist
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::where('is_active', true)
            ->findOrFail($validated['product_id']);

        $wishlist = $request->user()
            ->wishlists()
            ->firstOrCreate([
                'product_id' => $product->id,
            ]);

        $wishlist->load('product');

        return response()->json([
            'success' => true,
            'message' => $wishlist->wasRecentlyCreated
                ? 'Produk berhasil ditambahkan ke Wishlist.'
                : 'Produk sudah ada di Wishlist.',
            'wishlist' => $wishlist,
        ], $wishlist->wasRecentlyCreated ? 201 : 200);
    }

    // Menghapus produk dari Wishlist
    public function destroy(Request $request, Wishlist $wishlist)
    {
        $wishlist = $request->user()
            ->wishlists()
            ->findOrFail($wishlist->id);

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari Wishlist.',
        ]);
    }
}
