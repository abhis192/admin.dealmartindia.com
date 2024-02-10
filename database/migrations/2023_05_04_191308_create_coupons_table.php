<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('use');
            $table->string('type')->comment('fixed,percentage');
            $table->string('product_based')->comment('1=>on,0=>off')->nullable();
            $table->string('category_id')->nullable();
            $table->string('product_id')->nullable();
            $table->double('discount',10,2);
            $table->double('min_price',10,2);
            $table->double('max_price',10,2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('coupons');
    }
}
