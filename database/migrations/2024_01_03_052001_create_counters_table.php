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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('counter_count_one');
            $table->string('counter_name_one');

            $table->string('counter_count_two');
            $table->string('counter_name_two');

            $table->string('counter_count_three');
            $table->string('counter_name_three');

            $table->string('counter_count_four');
            $table->string('counter_name_four');

            $table->string('counter_count_five');
            $table->string('counter_name_five');

            $table->string('counter_count_six');
            $table->string('counter_name_six');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
