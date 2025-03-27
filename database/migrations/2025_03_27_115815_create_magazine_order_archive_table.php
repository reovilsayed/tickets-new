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

        Schema::create('magazine_order_archive', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magazine_order_id')->constrained('magazine_orders')->cascadeOnDelete();
            $table->foreignId('archive_id')->constrained('archives')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine_order_archive');
    }
};
