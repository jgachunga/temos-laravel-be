<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetColumnsToUserTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_targets', function (Blueprint $table) {
            $table->integer('lppc')->after('target')->nullable();
            $table->integer('coverage')->after('target')->nullable();
            $table->integer('strike_rate')->after('target')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_targets', function (Blueprint $table) {
            $table->dropColumn('lppc');
            $table->dropColumn('coverage');
            $table->dropColumn('strike_rate');
        });
    }
}
