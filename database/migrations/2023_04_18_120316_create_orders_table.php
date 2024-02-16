<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            // $table->string('source');
            $table->string('user_id')->nullable();
            $table->integer('order_address_id')->nullable();
            $table->integer('delivery_id')->nullable();
            // $table->date('date');
            $table->string('order_status')->comment('In Progress, Cancelled, Completed, Confirmed');
            $table->string('order_mode')->nullable()->comment('Cash On Delivery, Online Pay');
            $table->double('shipping_rate',10,2)->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('transaction_id')->nullable();
            // $table->double('commission_rate',10,2)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
