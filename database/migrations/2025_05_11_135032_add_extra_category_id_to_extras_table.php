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
        Schema::table('extras', function (Blueprint $table) {
            $table->unsignedBigInteger('extra_category_id')
                  ->nullable()
                  ->after('event_id');
            
            $table->foreign('extra_category_id')
                  ->references('id')
                  ->on('extra_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extras', function (Blueprint $table) {
            //
        });
    }
};
