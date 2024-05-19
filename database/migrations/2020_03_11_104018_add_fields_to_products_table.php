<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_multiple_prices')->after('structure_id')->default(false);
            $table->double('ex_factory_price', 8, 2)->after('structure_id')->nullable();
            $table->double('retail_price_recommended', 8, 2)->after('structure_id')->nullable();
            $table->integer('carton_pieces')->after('structure_id')->nullable();
            $table->double('carton_price')->after('structure_id')->nullable();
            $table->double('pre_tax_carton_price')->after('structure_id')->nullable();
            $table->double('pre_tax_price')->after('structure_id')->nullable();
            $table->double('taxable')->after('structure_id')->nullable();
            $table->boolean('vat_applicable')->after('structure_id')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('has_multiple_prices');
            $table->dropColumn('ex_factory_price');
            $table->dropColumn('retail_price_recommended');
            $table->dropColumn('carton_pieces');
            $table->dropColumn('taxable');
            $table->dropColumn('carton_price');
            $table->dropColumn('vat_applicable');
            $table->dropColumn('pre_tax_carton_price');
            $table->dropColumn('pre_tax_price');
        });
    }
}
