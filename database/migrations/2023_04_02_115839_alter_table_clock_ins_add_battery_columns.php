<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableClockInsAddBatteryColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->string('start_battery')->nullable();
            $table->string('end_battery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->dropColumn('start_battery');
            $table->dropColumn('end_battery');
        });
    }
}
