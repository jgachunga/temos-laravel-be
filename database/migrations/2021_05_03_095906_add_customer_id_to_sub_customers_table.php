<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToSubCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_customers', function (Blueprint $table) {
            $table->unsignedInteger('customer_id')->after('reg_by_rep_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_customers', function (Blueprint $table) {
            Schema::table('sub_customers', function (Blueprint $table) {
                $table->dropForeign('sub_customers_customer_id_foreign');
            });
            Schema::table('sub_customers', function (Blueprint $table) {
                $table->dropColumn('customer_id');
            });
        });
    }
}
