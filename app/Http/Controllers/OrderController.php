<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Membuat pesanan baru dari checkout customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address.recipient' => 'required|string|max:255',
            'address.phone' => 'required|string|max:30',
            'address.province' => 'required|string|max:100',
            'address.city' => 'required|string|max:100',
            'address.district' => 'required|string|max:100',
            'address.postalCode' => 'required|string|max:20',
            'address.detail' => 'required|string',

            'payment_method' => 'required|in:COD,Transfer Bank',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($request, $validated) {
            $subtotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$product || !$product->is_active) {
                    throw ValidationException::withMessages([
                        'items' => 'Salah satu produk sudah tidak tersedia.',
                    ]);
                }

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk {$product->name} tidak mencukupi.",
                    ]);
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'variant' => $product->variant,
                    'image_url' => $product->image_url
                        ?? ($product->image
                            ? asset('storage/' . $product->image)
                            : null),
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ];

                // Kurangi stok produk.
                $product->decrement('stock', $item['quantity']);
            }

            $address = $validated['address'];

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => 'GS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),

                'recipient' => $address['recipient'],
                'phone' => $address['phone'],
                'province' => $address['province'],
                'city' => $address['city'],
                'district' => $address['district'],
                'postal_code' => $address['postalCode'],
                'address_detail' => $address['detail'],

                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total' => $subtotal,
                'status' => 'Pesanan Dibuat',
            ]);

            $order->items()->createMany($orderItems);

            return $order->load('items');
        });

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'order' => $order,
        ], 201);
    }

    /**
     * Mengambil seluruh pesanan milik customer yang login.
     */
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    /**
     * Mengambil detail satu pesanan milik customer.
     */
    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses ke pesanan ini.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'order' => $order->load('items'),
        ]);
    }

    /**
 * Mengambil seluruh pesanan untuk dashboard admin.
 */
        public function adminIndex()
        {
            $orders = Order::with(['user', 'items'])
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'orders' => $orders,
            ]);
        }

        /**
 * Mengubah status pesanan melalui dashboard admin.
 */

public function updateStatus(Request $request, Order $order)
{
    $validated = $request->validate([
        'status' => [
            'required',
            'in:Pesanan Dibuat,Diproses,Dikirim,Selesai,Dibatalkan',
        ],
    ]);

    $newStatus = $validated['status'];

    try {
        $updatedOrder = DB::transaction(function () use ($order, $newStatus) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $previousStatus = $lockedOrder->status;

            // Pesanan yang sudah dibatalkan tidak dapat diaktifkan kembali.
            if ($previousStatus === 'Dibatalkan' && $newStatus !== 'Dibatalkan') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Pesanan yang sudah dibatalkan tidak dapat diaktifkan kembali.',
                ]);
            }

            // Jika sudah dibatalkan, jangan kembalikan stok lagi.
            if ($previousStatus === 'Dibatalkan' && $newStatus === 'Dibatalkan') {
                return $lockedOrder;
            }

            // Pesanan yang sudah dikirim atau selesai tidak dapat dibatalkan.
            if (
                $newStatus === 'Dibatalkan' &&
                in_array($previousStatus, ['Dikirim', 'Selesai'])
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Pesanan yang sudah dikirim atau selesai tidak dapat dibatalkan.',
                ]);
            }

            // Kembalikan stok ketika admin membatalkan pesanan.
            if ($newStatus === 'Dibatalkan') {
                $lockedOrder->load('items');

                foreach ($lockedOrder->items as $item) {
                    if ($item->product_id) {
                        $product = \App\Models\Product::whereKey($item->product_id)
                            ->lockForUpdate()
                            ->first();

                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            }

            $lockedOrder->update([
                'status' => $newStatus,
            ]);

            return $lockedOrder;
        });

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui.',
            'order' => $updatedOrder->load(['user', 'items']),
        ]);
    } catch (\Illuminate\Validation\ValidationException $error) {
        throw $error;
    } catch (\Throwable $error) {
        \Illuminate\Support\Facades\Log::error(
            'Update order status error: ' . $error->getMessage()
        );

        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui status pesanan.',
        ], 500);
    }
}



/**
 * Membatalkan pesanan oleh customer.
 */
public function cancel(Request $request, Order $order)
{
    $result = DB::transaction(function () use ($request, $order) {
        // Kunci pesanan agar tidak diproses bersamaan.
        $order = Order::whereKey($order->id)
            ->lockForUpdate()
            ->firstOrFail();

        // Pastikan pesanan milik customer yang login.
        if ($order->user_id !== $request->user()->id) {
            return [
                'error' => true,
                'status' => 403,
                'message' => 'Kamu tidak memiliki akses ke pesanan ini.',
            ];
        }

        // Hanya pesanan yang belum diproses yang dapat dibatalkan.
        if ($order->status !== 'Pesanan Dibuat') {
            return [
                'error' => true,
                'status' => 422,
                'message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses.',
            ];
        }

        // Kembalikan stok setiap produk.
        $order->load('items');

        foreach ($order->items as $item) {
            if (!$item->product_id) {
                continue;
            }

            $product = Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->first();

            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        // Perbarui status pesanan.
        $order->update([
            'status' => 'Dibatalkan',
        ]);

        return [
            'error' => false,
            'order' => $order->load('items'),
        ];
    });

    if ($result['error']) {
        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], $result['status']);
    }

    return response()->json([
        'success' => true,
        'message' => 'Pesanan berhasil dibatalkan.',
        'order' => $result['order'],
    ]);
}

}
