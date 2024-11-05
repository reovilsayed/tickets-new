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
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('invite_id')->nullable();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->bigInteger('invite_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('invite_id');
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('invite_id');
        });
    }
};
