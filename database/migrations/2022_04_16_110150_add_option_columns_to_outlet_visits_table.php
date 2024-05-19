<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionColumnsToOutletVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outlet_visits', function (Blueprint $table) {
            $table->unsignedBigInteger('current_status_option_id')->nullable()->after('current_status_id');
            $table->string('option_selected')->nullable()->after('status');
            $table->string('current_status')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outlet_visits', function (Blueprint $table) {
            $table->dropColumn('option_selected');
            $table->dropColumn('current_status');
            $table->dropColumn('current_status_option_id');
        });
    }
}
