<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('product_id');
            $table->integer('qty')->nullable();
            $table->string('qty_type')->nullable();
            $table->integer('qty_weight')->nullable();
            // $table->integer('product_price')->nullable();
            $table->integer('regular_price')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            // $table->string('final_price')->nullable();
            $table->string('sale_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
