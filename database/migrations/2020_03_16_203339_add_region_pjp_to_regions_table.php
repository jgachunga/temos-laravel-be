<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegionPjpToRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->bigInteger('region_pjp')->after('desc')->unsigned()->nullable();
            $table->foreign('region_pjp')->references('id')->on('region_pjps');

            $table->bigInteger('user_id')->after('desc')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign('regions_region_pjp_foreign');
            $table->dropColumn('region_pjp');
            $table->dropForeign('regions_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
