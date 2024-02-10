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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('qty_type')->nullable();
            $table->integer('qty_weight')->nullable();
            $table->string('product_price')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('final_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
