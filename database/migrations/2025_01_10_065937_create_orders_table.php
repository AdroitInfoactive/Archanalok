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
            $table->string('financial_year')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('temp_invoice_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('billing_address_id')->constrained('addresses')->onDelete('cascade');
            $table->text('billing_address')->nullable();
            $table->foreignId('shipping_address_id')->constrained('addresses')->onDelete('cascade');
            $table->text('shipping_address')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->double('subtotal');
            $table->double('grand_total');
            $table->integer('quantity');
            $table->enum('payment_method',['Online','Offline']);
            $table->string('payment_type')->nullable();
            $table->boolean('payment_status')->default('0');
            $table->string('transaction_id')->nullable();
            $table->enum('order_status',['Pending','Placed','Payment Received','Shipped','Delivered', 'Cancelled', 'Returned']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
