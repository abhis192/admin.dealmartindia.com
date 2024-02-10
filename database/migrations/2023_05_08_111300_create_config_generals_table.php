<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_generals', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('site_email')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->longText('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->longText('meta_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->tinyInteger('topbar_header')->default(1);
            $table->string('logo')->default('logo.png')->nullable();
            $table->string('icon')->default('icon.png')->nullable();
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
        Schema::dropIfExists('config_generals');
    }
}
