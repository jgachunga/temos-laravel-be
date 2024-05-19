<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('active');
            $table->double('target');
            $table->bigInteger('create_by')->unsigned()->nullable();
            $table->integer('structure_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('create_by')->references('id')->on('users');
            $table->foreign('structure_id')->references('id')->on('sale_structures');
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign('user_targets_user_id_foreign');
            $table->dropForeign('user_targets_create_by_foreign');
            $table->dropForeign('user_targets_structure_id_foreign');
        });
        Schema::dropIfExists('user_targets');
    }
}
