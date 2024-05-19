<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('invoice_id');
            $table->unsignedInteger('product_id');
            $table->string('product_code')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity');
            $table->string('taxes');
            $table->string('total_amount');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
