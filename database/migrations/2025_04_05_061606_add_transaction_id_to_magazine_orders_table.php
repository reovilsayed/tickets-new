<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->tinyInteger('payment_status')->default(0);
            $table->string('invoice_id')->nullable();
            $table->string('invoice_url')->nullable();
            $table->longText('invoice_body')->nullable();
            $table->string('payment_link')->nullable();
            $table->string('payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->dropColumn('invoice_id');
            $table->dropColumn('invoice_body');
            $table->dropColumn('invoice_url');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_link');
            $table->dropColumn('payment_id');
        });
    }
};
