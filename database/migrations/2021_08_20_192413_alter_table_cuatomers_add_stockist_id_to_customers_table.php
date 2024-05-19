<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCuatomersAddStockistIdToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('stockist_id')->after('route_id')->nullable();
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_stockist_id_foreign');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('stockist_id');
        });
    }
}
