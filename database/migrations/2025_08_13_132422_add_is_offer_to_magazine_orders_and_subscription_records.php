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
            $table->boolean('is_offer')->default(false)->after('payment_status');
        });

        Schema::table('subscription_records', function (Blueprint $table) {
            $table->boolean('is_offer')->default(false)->after('shipping_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->dropColumn('is_offer');
        });

        Schema::table('subscription_records', function (Blueprint $table) {
            $table->dropColumn('is_offer');
        });
    }
};
