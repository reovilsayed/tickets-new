<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('tax')->nullable()->after('price');
            $table->integer('secondary_tax')->nullable()->after('tax');
            $table->integer('secondary_tax_percentage')->nullable()->after('secondary_tax');
            $table->integer('tartiary_tax')->nullable()->after('secondary_tax_percentage');
            $table->integer('tartiary_tax_percentage')->nullable()->after('tartiary_tax');
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
            $table->dropColumn('tax');
            $table->dropColumn('secondary_tax');
            $table->dropColumn('secondary_tax_percentage');
            $table->dropColumn('tartiary_tax');
            $table->dropColumn('tartiary_tax_percentage');
        });
    }
};
