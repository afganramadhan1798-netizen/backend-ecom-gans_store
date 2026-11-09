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
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('product_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        // Snapshot produk saat pesanan dibuat
        $table->string('product_name');
        $table->string('variant')->nullable();
        $table->string('image_url')->nullable();

        $table->unsignedBigInteger('price');
        $table->unsignedInteger('quantity');
        $table->unsignedBigInteger('subtotal');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
