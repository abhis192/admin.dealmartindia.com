<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('user_id')->comment('creator');
            $table->string('type_id')->nullable();
            $table->string('category_id')->nullable();
            // $table->integer('brand_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('meta_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            // $table->double('regular_price')->nullable();
            // $table->double('sale_price')->nullable();
            $table->string('image')->default('default.jpg');
            // $table->integer('shipping_days')->default(3)->nullable();
            $table->tinyInteger('published')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->integer('in_stock')->default(0)->nullable();
            $table->tinyInteger('addon')->default(0);
            $table->tinyInteger('eggless')->default(0);
            $table->string('photo_cake')->default(0)->nullable();
            $table->string('message')->default(0)->nullable();
            $table->string('cake_flavour')->default(0)->nullable();
            $table->tinyInteger('heart_shape')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
    // 'photo_cake','message','heart_shape'
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
