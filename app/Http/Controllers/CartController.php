<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Mengambil keranjang milik user yang sedang login
    public function index(Request $request)
    {
        $cart = Cart::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->first();

        return response()->json([
            'cart' => $cart,
        ]);
    }

    // Menambahkan produk ke keranjang
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = DB::transaction(function () use ($request, $validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (!$product->is_active) {
                abort(422, 'Produk sedang tidak tersedia.');
            }

            $cart = Cart::firstOrCreate([
                'user_id' => $request->user()->id,
            ]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            $newQuantity = ($cartItem?->quantity ?? 0)
                + $validated['quantity'];

            if ($newQuantity > $product->stock) {
                abort(422, 'Jumlah produk melebihi stok yang tersedia.');
            }

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $validated['quantity'],
                ]);
            }

            return $cart;
        });

        $cart->load(['items.product']);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'cart' => $cart,
        ], 201);
    }

    // Mengubah jumlah produk dalam keranjang
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::whereKey($cartItem->id)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if (!$product->is_active) {
            abort(422, 'Produk sedang tidak tersedia.');
        }

        if ($validated['quantity'] > $product->stock) {
            abort(422, 'Jumlah produk melebihi stok yang tersedia.');
        }

        $cartItem->update([
            'quantity' => $validated['quantity'],
        ]);

        $cart = Cart::with(['items.product'])
            ->findOrFail($cartItem->cart_id);

        return response()->json([
            'message' => 'Jumlah produk berhasil diperbarui.',
            'cart' => $cart,
        ]);
    }

    // Menghapus satu produk dari keranjang
    public function destroy(Request $request, CartItem $cartItem)
    {
        $cartItem = CartItem::whereKey($cartItem->id)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->firstOrFail();

        $cartId = $cartItem->cart_id;

        $cartItem->delete();

        $cart = Cart::with(['items.product'])
            ->findOrFail($cartId);

        return response()->json([
            'message' => 'Produk berhasil dihapus dari keranjang.',
            'cart' => $cart,
        ]);
    }

    // Mengosongkan seluruh keranjang
    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)
            ->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'message' => 'Keranjang berhasil dikosongkan.',
        ]);
    }
}
