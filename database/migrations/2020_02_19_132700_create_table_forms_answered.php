<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormsAnswered extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 45);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('forms_answered', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->bigInteger('status_id')->unsigned()->nullable(false);
            $table->string('status')->nullable();
            $table->string('reason')->nullable();
            $table->string('other_reasons')->nullable();
            $table->boolean('has_answers')->default(false);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->timestamp('duration')->nullable();
            $table->decimal('lat', 8, 2)->nullable();
            $table->decimal('long', 8, 2)->nullable();
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->decimal('latitude', 8, 2)->nullable();
            $table->boolean('mocked')->default(false);
            $table->timestamp('geotimestamp')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('status_id')->references('id')->on('form_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms_answered');
    }
}
