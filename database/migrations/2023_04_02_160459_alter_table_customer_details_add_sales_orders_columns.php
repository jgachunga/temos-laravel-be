<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCustomerDetailsAddSalesOrdersColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_survey_details', function (Blueprint $table) {
            $table->integer('sales')->nullable()->after('category');
            $table->integer('orders')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_survey_details', function (Blueprint $table) {
            $table->dropColumn('sales');
            $table->dropColumn('orders');
        });
    }
}
