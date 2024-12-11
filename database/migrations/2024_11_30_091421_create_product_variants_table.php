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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->string('variation_code'); // Code to identify the variation (e.g., "color/size")
            $table->string('sku')->unique(); // Unique SKU for the variant
            $table->decimal('sale_price', 10, 2)->nullable(); // Sale price
            $table->decimal('offer_price', 10, 2)->nullable(); // Offer price
            $table->decimal('distributor_price', 10, 2)->nullable(); // Distributor price
            $table->decimal('wholesale_price', 10, 2)->nullable(); // Wholesale price
            $table->integer('min_order_qty')->default(1); // Minimum order quantity
            $table->decimal('weight', 8, 2)->nullable(); // Weight of the variant
            $table->integer('qty')->default(0); // Stock quantity for this variant
            $table->boolean('status')->default(1); // Active or inactive
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
