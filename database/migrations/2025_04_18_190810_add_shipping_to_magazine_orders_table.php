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
            $table->decimal('shipping', 10, 2)->nullable();
            $table->json('shipping_info')->nullable();
        });
        Schema::table('subscription_records', function (Blueprint $table) {
            $table->json('shipping_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->dropColumn('shipping');
            $table->dropColumn('shipping_info');
        });
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->dropColumn('shipping');
        });
    }
};
