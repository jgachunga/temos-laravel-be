<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned();
            $table->integer('channel_id')->unsigned();
            $table->double('price')->unsigned()->nullable();
            $table->double('purchase_price')->unsigned()->nullable();
            $table->double('selling_price')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
}
