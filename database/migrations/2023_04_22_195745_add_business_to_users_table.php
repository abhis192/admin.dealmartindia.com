<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('business')->nullable()->after('avatar');
            $table->longText('address')->nullable()->after('business');
            $table->integer('category_id')->nullable()->after('address');
            $table->double('wallet_balance',10,2)->default(0.00)->nullable()->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('business');
            $table->dropColumn('address');
            $table->dropColumn('category_id');
            $table->dropColumn('wallet_balance');
        });
    }
}
