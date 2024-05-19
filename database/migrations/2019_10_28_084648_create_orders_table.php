<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('structure_id')->unsigned()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('order_ref')->nullable();
            $table->string('pax')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('amount_payable')->nullable();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('opened_by')->nullable();
            $table->unsignedInteger('closed_by')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->unsignedInteger('terminal_id')->nullable();
            $table->unsignedInteger('shift_id')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_shown')->default(true);
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_void')->default(false);
            $table->string('display_name')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 10, 8)->nullable();
            $table->string('accuracy', 50)->nullable();
            $table->boolean('mocked')->nullable();
            $table->timestamp('loctimestamp')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('structure_id')
                ->references('id')->on('sale_structures')
                ->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
