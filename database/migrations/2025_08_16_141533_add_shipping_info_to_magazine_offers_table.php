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
        Schema::table('magazine_offers', function (Blueprint $table) {
            $table->json('shipping_info')->nullable()->after('subscription_magazine_details_id');
        });
    }

    public function down(): void
    {
        Schema::table('magazine_offers', function (Blueprint $table) {
            $table->dropColumn('shipping_info');
        });
    }
};
