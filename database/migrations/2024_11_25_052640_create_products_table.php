
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('main_category_id')->constrained('main_categories')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->string('brand');
            $table->string('material');
            $table->string('units');
            $table->string('weight_type');
            $table->string('file')->nullable();
            $table->string('other_code')->nullable();
            $table->integer('gst')->nullable();
            $table->boolean('has_variants');
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->decimal('distributor_price', 10, 2)->nullable();
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->integer('min_order_qty')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->text('variation_ids')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
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
        Schema::dropIfExists('products');
    }
};
