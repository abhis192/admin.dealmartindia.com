<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            // $table->integer('seller_id');
            $table->integer('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('qty_type')->nullable();
            $table->string('qty_weight')->nullable();
            $table->integer('qty');
            $table->double('sale_price',10,2);
            // $table->double('tax',10,2)->nullable();
            $table->double('discount_type',10,2)->nullable();
            $table->double('discount',10,2)->nullable();
            $table->double('coupon_discount',10,2)->nullable();
            // $table->tinyInteger('refund_status')->default(0)->nullable()->comment('');
            $table->string('image')->default('default.jpg');
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
        Schema::dropIfExists('order_items');
    }
}
