<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableFormsAnsweredAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->string('uuid')->nullable();
            $table->integer('answered')->default(0);
            $table->integer('questionCount')->nullable();
            $table->integer('uploaded')->default(0);
            $table->integer('photos')->default(0);
            $table->integer('uploadedPhotos')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms_answered', function (Blueprint $table) {
            //
        });
    }
}
