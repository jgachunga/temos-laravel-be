<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRouteIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('route_id')->after('structure_id')->unsigned()->nullable();
            $table->foreign('route_id')->references('id')->on('routes');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->bigInteger('route_id')->after('structure_id')->unsigned()->nullable();
            $table->foreign('route_id')->references('id')->on('routes');

        });
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->bigInteger('route_id')->after('geotimestamp')->unsigned()->nullable();
            $table->foreign('route_id')->references('id')->on('routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_route_id_foreign');
            $table->dropColumn('route_id');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('users_route_id_foreign');
            $table->dropColumn('route_id');
        });
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->dropForeign('users_route_id_foreign');
            $table->dropColumn('route_id');
        });
    }
}
