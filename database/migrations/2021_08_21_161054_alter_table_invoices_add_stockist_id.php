<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInvoicesAddStockistId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('stockist_id')->after('customer_id')->nullable();
            $table->foreign('stockist_id')->references('id')->on('stockists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_stockist_id_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('stockist_id');
        });
    }
}
