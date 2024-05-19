<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUomIdToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->bigInteger('uom_id')->after('sku')->unsigned()->nullable();
            $table->integer('product_id')->after('order_id')->unsigned()->nullable();
            $table->foreign('uom_id')->references('id')->on('uoms');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_uom_id_foreign');
            $table->dropColumn('uom_id');
            $table->dropForeign('order_details_product_id_foreign');
            $table->dropColumn('product_id');
        });
    }
}
