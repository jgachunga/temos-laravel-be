<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStructureIdToSubCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_customers', function (Blueprint $table) {
            $table->unsignedInteger('structure_id')->after('heading')->nullable();
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
        Schema::table('sub_customers', function (Blueprint $table) {
            $table->dropForeign('sub_customers_structure_id_foreign');
        });
        Schema::table('sub_customers', function (Blueprint $table) {
            $table->dropColumn('structure_id');
        });
    }
}
