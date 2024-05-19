<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRoutesTableRemoveForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign('routes_stockist_id_foreign');
        });
        Schema::table('routes', function (Blueprint $table) {
            $table->unsignedBigInteger('stockist_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->unsignedBigInteger('stockist_id')->change();
            $table->foreign('stockist_id')->references('id')->on('stockists');
        });
    }
}
