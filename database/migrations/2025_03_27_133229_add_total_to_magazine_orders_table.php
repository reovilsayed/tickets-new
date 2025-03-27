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
            $table->decimal('total', 10, 2)->after('billing'); // Adjust the 'after' column if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magazine_orders', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
