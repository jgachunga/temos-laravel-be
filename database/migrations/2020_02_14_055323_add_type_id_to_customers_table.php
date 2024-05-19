<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeIdToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->bigInteger('type_id')->after('channel_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('types');
            $table->boolean('mocked')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
