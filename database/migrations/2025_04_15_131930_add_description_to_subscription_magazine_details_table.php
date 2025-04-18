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
        Schema::table('subscription_magazine_details', function (Blueprint $table) {
            $table->text('description')->nullable()->comment('Subscription description')->after('recurring_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_magazine_details', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
