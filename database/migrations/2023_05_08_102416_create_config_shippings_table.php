<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_shippings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('free_shipping_status')->default(0);
            $table->double('min_order_to_ship')->default(499);
            $table->tinyInteger('universal_ship_status')->default(0);
            $table->double('universal_ship_cost')->default(49);
            $table->integer('universal_shipping_days');
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
        Schema::dropIfExists('config_shippings');
    }
}
