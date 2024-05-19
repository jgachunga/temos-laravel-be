<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCDetailIdColumnToFormsAnsweredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->string('c_detail_uuid')->nullable()->after('customer_id');

            $table->foreign('c_detail_uuid')->references('c_detail_uuid')->on('customer_survey_details');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('c_detail_uuid')->nullable()->after('customer_id');

            $table->foreign('c_detail_uuid')->references('c_detail_uuid')->on('customer_survey_details');
        });
        Schema::table('form_answers', function (Blueprint $table) {
            $table->string('c_detail_uuid')->nullable()->after('question_id');

            $table->foreign('c_detail_uuid')->references('c_detail_uuid')->on('customer_survey_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->dropForeign('forms_answered_c_detail_uuid_foreign');
        });
        Schema::table('forms_answered', function (Blueprint $table) {
            $table->dropColumn('c_detail_uuid');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_c_detail_uuid_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('c_detail_uuid');
        });
        Schema::table('form_answers', function (Blueprint $table) {
            $table->dropForeign('form_answers_c_detail_uuid_foreign');
        });
        Schema::table('form_answers', function (Blueprint $table) {
            $table->dropColumn('c_detail_uuid');
        });
        Schema::enableForeignKeyConstraints();
    }
}
