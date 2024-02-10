<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('product_price', 10, 2)->after('qty_weight');
            $table->string('discount_type')->nullable()->after('product_price');
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
            $table->decimal('final_price', 10, 2)->nullable()->after('discount_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('product_price');
            $table->dropColumn('discount_type');
            $table->dropColumn('discount_value');
            $table->dropColumn('final_price');
        });
    }
};
