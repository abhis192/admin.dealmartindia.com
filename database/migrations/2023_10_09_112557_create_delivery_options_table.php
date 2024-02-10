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
        Schema::create('delivery_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_name');
            $table->string('delivery_charge')->nullable();
            $table->string('time_slot_inside')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1=>Active,0=>Disabled');
            $table->tinyInteger('cod')->default(0)->comment('1=>Active,0=>Disabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_options');
    }
};
