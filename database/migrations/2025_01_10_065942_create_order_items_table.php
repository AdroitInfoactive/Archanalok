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
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('product_name');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->text('variant_name')->nullable();
            $table->integer('quantity');
            $table->double('sale_price')->nullable();
            $table->double('offer_price')->nullable();
            $table->double('tax');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
