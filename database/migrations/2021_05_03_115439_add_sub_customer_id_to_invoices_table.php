<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubCustomerIdToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_customer_id')->after('customer_id')->nullable();
            $table->foreign('sub_customer_id')->references('id')->on('sub_customers');
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
            $table->dropForeign('invoices_sub_customer_id_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('sub_customer_id');
        });
    }
}
