<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref');
            $table->string('business_code');
            $table->string('discount')->nullable();
            $table->string('total_tax')->nullable();
            $table->decimal('sub_total', 8, 2)->nullable();
            $table->decimal('grand_total', 8, 2)->nullable();
            $table->timestamp('date_due')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->unsignedInteger('customer_id');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('updated_by');
            $table->text('payment_details');
            $table->text('terms');
            $table->text('footer');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('structure_id')->nullable();
            $table->foreign('structure_id')->references('id')->on('sale_structures');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
