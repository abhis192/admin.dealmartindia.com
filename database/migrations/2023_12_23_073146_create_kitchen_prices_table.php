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
        Schema::create('kitchen_prices', function (Blueprint $table) {
            $table->id();
            $table->string('kitchen_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('qty_type')->nullable();
            $table->integer('qty_weight')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchen_prices');
    }
};
