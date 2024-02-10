<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePincodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pincodes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('city_id');
            // $table->integer('state_id')->nullable();
            // $table->integer('country_id')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=>Active,0=>Disabled');
            $table->timestamps();

        //     $table->foreign('city_id')
        //     ->references('id')
        //     ->on('cities')
        //     ->cascadeOnUpdate()
        //     ->cascadeOnDelete();

        // $table->foreign('state_id')
        //     ->references('id')
        //     ->on('states')
        //     ->cascadeOnUpdate()
        //     ->cascadeOnDelete();

        // $table->foreign('country_id')
        //     ->references('id')
        //     ->on('countries')
        //     ->cascadeOnUpdate()
        //     ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pincodes');
    }
}
