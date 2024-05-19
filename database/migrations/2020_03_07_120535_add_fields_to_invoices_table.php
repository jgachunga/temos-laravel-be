<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->nullable()->after('footer');
            $table->decimal('lng', 10, 8)->nullable()->after('footer');
            $table->string('accuracy', 50)->nullable()->after('footer');
            $table->boolean('mocked')->nullable()->after('footer');
            $table->timestamp('loctimestamp')->nullable()->after('footer');
            $table->unsignedBigInteger('user_id')->after('id');

            $table->unsignedBigInteger('updated_by')->nullable()->change();
            $table->string('ref', 45)->nullable()->change();
            $table->string('business_code', 45)->nullable()->change();

            $table->text('payment_details')->nullable()->change();
            $table->text('terms')->nullable()->change();
            $table->text('footer')->nullable()->change();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_user_id_foreign');
            $table->dropForeign('invoices_created_by_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('accuracy');
            $table->dropColumn('mocked');
            $table->dropColumn('loctimestamp');
            $table->dropColumn('user_id');
        });
    }
}
