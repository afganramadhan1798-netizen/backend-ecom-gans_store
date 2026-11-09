<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')
            ->constrained()
            ->restrictOnDelete();

        $table->string('order_number')->unique();

        // Alamat pengiriman
        $table->string('recipient');
        $table->string('phone');
        $table->string('province');
        $table->string('city');
        $table->string('district');
        $table->string('postal_code');
        $table->text('address_detail');

        // Pembayaran dan total
        $table->string('payment_method');
        $table->unsignedBigInteger('subtotal');
        $table->unsignedBigInteger('shipping_cost')->default(0);
        $table->unsignedBigInteger('total');

        // Status pesanan
        $table->string('status')->default('Pesanan Dibuat');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};