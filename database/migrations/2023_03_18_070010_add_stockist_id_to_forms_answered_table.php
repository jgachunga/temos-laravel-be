<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockistIdToFormsAnsweredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->unsignedBigInteger('stockist_id')->nullable()->after('customer_id');

            $table->foreign('stockist_id')->references('id')->on('stockists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->dropForeign('forms_answered_stockist_id_foreign');
        });
        
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->dropColumn('stockist_id');
        });
    }
}
