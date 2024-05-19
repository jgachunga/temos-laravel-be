<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('desc')->nullable();
            $table->integer('cat_id')->unsigned()->nullable();
            $table->double('price')->nullable();
            $table->string('img_url', 100)->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->double('discount')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cat_id')->references('id')->on('categories');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
