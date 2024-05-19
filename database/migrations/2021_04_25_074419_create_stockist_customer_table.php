<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockistCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockist_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stockist_id');
            $table->unsignedInteger('customer_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stockist_id')->references('id')->on('routes');
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
        Schema::table('stockist_customer', function (Blueprint $table) {
            $table->dropForeign('stockist_customer_route_id_foreign');
            $table->dropForeign('stockist_customer_customer_id_foreign');

        });
        Schema::dropIfExists('stockist_customer');
    }
}
