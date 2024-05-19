<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEmailUserFieldNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 70)->nullable()->change();
            $table->boolean('is_customer')->default(false)->after('username');
            $table->boolean('is_rep')->default(false)->after('username');
            $table->integer('cust_id')->unsigned()->nullable()->after('username');
            $table->integer('rep_id')->unsigned()->nullable()->after('username');
            $table->foreign('cust_id')->references('id')->on('customers');
            $table->foreign('rep_id')->references('id')->on('sales_reps');
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
            $table->dropColumn('is_customer');
            $table->dropColumn('is_rep');
            $table->dropColumn('cust_id');
            $table->dropColumn('rep_id');
        });
    }
}
