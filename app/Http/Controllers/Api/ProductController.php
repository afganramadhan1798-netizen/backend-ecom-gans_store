<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Mengambil semua produk
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->get()
            ->map(function ($product) {
                $product->image_url = $product->image
                    ? asset('storage/' . $product->image)
                    : null;

                return $product;
            });

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }


// Mengambil semua produk khusus admin
    public function adminIndex()
    {
        $products = Product::with('category')
            ->latest()
            ->get()
            ->map(function ($product) {
                $product->image_url = $product->image
                    ? asset('storage/' . $product->image)
                    : null;

                return $product;
            });

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    // Menambahkan produk
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bestseller' => 'sometimes|boolean',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product = Product::create($validated);

        $product->load('category');

        $product->image_url = $product->image
            ? asset('storage/' . $product->image)
            : null;

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'product' => $product,
        ], 201);
    }

    // Mengambil detail produk
    public function show(Product $product)
    {
        $product->load('category');

        $product->image_url = $product->image
            ? asset('storage/' . $product->image)
            : null;

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'price' => 'sometimes|required|integer|min:0',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bestseller' => 'sometimes|boolean',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        $product->refresh()->load('category');

        $product->image_url = $product->image
            ? asset('storage/' . $product->image)
            : null;

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui.',
            'product' => $product,
        ]);
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.',
        ]);
    }
}