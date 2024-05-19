<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomerSurveyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_survey_details', function (Blueprint $table) {
            $table->string('c_detail_uuid')->nullable()->after('id');
            $table->string('customer_uuid')->nullable()->after('customer_id');

            $table->index('c_detail_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_survey_details', function (Blueprint $table) {
            $table->dropColumn('c_detail_uuid');
            $table->dropColumn('customer_uuid');
        });
    }
}
