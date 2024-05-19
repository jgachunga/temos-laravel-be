<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddLastSeen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen')->nullable();
            $table->string('battery')->nullable();
            $table->string('device')->nullable();
            $table->string('app_version')->nullable();
            $table->string('android_version')->nullable();
            $table->string('imei')->nullable();
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
            $table->dropColumn('last_seen');
            $table->dropColumn('battery');
            $table->dropColumn('device');
            $table->dropColumn('app_version');
            $table->dropColumn('android_version');
            $table->dropColumn('imei');
        });
    }
}
