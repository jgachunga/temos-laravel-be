<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_categories', function (Blueprint $table) {
            $table->boolean('active')->after('name')->default(0);
            $table->date('from')->nullable();
            $table->date('to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_categories', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
}
