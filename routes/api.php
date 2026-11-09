<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Api\AddressController;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
// Melihat semua produk
Route::get('/products', [ProductController::class, 'index']);
// Melihat detail produk
Route::get('/products/{product}', [ProductController::class, 'show']);
 // Kategori untuk pengguna
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    EnsureUserIsActive::class,
])->group(function () {

    // Data pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/items', [CartController::class, 'store']);
    Route::patch('/cart/items/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy']);

    Route::get('/address', [AddressController::class, 'index']);
    Route::put('/address', [AddressController::class, 'update']);
    
    // Logout
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // USER MANAGEMENT (ADMIN)
    Route::get('/admin/users', function (Request $request) {

        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses hanya untuk admin.',
            ], 403);
        }

        $users = User::select(
            'id',
            'name',
            'username',
            'email',
            'role',
            'is_active',
            'created_at'
        )
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    });

    // Mengubah role pengguna
    Route::patch('/admin/users/{id}/role', function (Request $request, $id) {

        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses hanya untuk admin.',
            ], 403);
        }

        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'Kamu tidak dapat mengubah role akun sendiri.',
            ], 403);
        }

        $validated = $request->validate([
            'role' => 'required|in:customer,admin',
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role pengguna berhasil diperbarui.',
            'user' => $user,
        ]);
    });

    // Mengubah status pengguna
    Route::patch('/admin/users/{id}/status', function (Request $request, $id) {

        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses hanya untuk admin.',
            ], 403);
        }

        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'Kamu tidak dapat mengubah status akun sendiri.',
            ], 403);
        }

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pengguna berhasil diperbarui.',
            'user' => $user,
        ]);
    });

    // PRODUCT MANAGEMENT
    // Khusus admin
    Route::middleware(EnsureUserIsAdmin::class)->group(function () {
        //Mengambil semua produk untuk admin
        Route::get('/admin/products', [ProductController::class, 'adminIndex']);
        // Menambahkan produk
        Route::post('/admin/products', [ProductController::class, 'store']);
        // Mengedit produk
        Route::put('/admin/products/{product}', [ProductController::class, 'update']);
        // Menghapus produk
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy']);
    });

    // Khusus admin
    Route::middleware(EnsureUserIsAdmin::class)->group(function () {
        Route::get('/admin/categories', [CategoryController::class, 'adminIndex']);
        Route::post('/admin/categories', [CategoryController::class, 'store']);
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy']);

        Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
        Route::patch('/admin/orders/{order}/status', [OrderController::class,'updateStatus',]);
});
});
