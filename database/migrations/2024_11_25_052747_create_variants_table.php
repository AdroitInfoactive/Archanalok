<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Example: Color, Size
            $table->string('value'); // Example: Red, Medium
            $table->decimal('price', 10, 2); // Variant-specific price
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->string('image_path')->nullable(); // Optional image for the variant
            $table->integer('priority')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
