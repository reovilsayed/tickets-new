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
        foreach (['extras', 'tickets'] as $ticket) {
            Schema::table($ticket, function (Blueprint $table) {
                $table->string('toconline_item_code')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['extras', 'tickets'] as $ticket) {
            Schema::table('extras', function (Blueprint $table) {
                $table->dropColumn('toconline_item_code');
            });
        }
    }
};
