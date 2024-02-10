<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->unsignedBigInteger('product_id'); // Foreign key to link to the "products" table
            $table->string('city_id');
            $table->json('pricing_rules'); // JSON column to store pricing rules as JSON
            $table->boolean('status')->default(0); // Status column with default value true (1 for active, 0 for inactive)
            $table->timestamps(); // Created_at and updated_at timestamps

            // Define foreign key constraint to link to the "products" table
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }


    // $table->unsignedBigInteger('product_id');
    // $table->string('city_id')->nullable();
    // $table->string('qty_type')->nullable();
    // $table->integer('qty')->nullable();
    // $table->string('product_price')->nullable();
    // $table->string('discount_type')->nullable();
    // $table->string('discount_value')->nullable();
    // $table->string('final_price')->nullable();
    // // $table->json('pricing_rules');
    // $table->boolean('status')->default(1);
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_rules');
    }
}
