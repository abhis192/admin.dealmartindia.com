<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_statuses', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->after('order_status');
            $table->string('updated_by')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_statuses', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('updated_by');
        });
    }
}
