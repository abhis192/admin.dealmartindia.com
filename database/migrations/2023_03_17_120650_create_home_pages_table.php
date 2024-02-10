<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('section_1')->nullable()->default('default.jpg');
            $table->integer('section_2')->nullable();
            $table->integer('section_3')->nullable();
            $table->string('section_4')->nullable()->default('default.jpg');
            $table->string('section_5')->nullable()->default('default.jpg');
            $table->integer('section_6')->nullable();
            $table->integer('section_7')->nullable();
            $table->string('section_8')->nullable()->default('default.jpg');
            $table->string('section_9')->nullable()->default('default.jpg');
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
        Schema::dropIfExists('home_pages');
    }
}
