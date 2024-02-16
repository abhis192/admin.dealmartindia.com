<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            // $table->string('user_id');
            $table->string('label');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->longText('address');
            $table->longText('landmark')->nullable();
            $table->string('pincode');
            // $table->string('area');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            // $table->tinyInteger('default')->default(0);
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
        Schema::dropIfExists('order_addresses');
    }
}
