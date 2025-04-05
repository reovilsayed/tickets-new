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
        Schema::create('magazine_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magazine_order_id')->constrained('magazine_orders','id')->cascadeOnDelete();
            $table->string('itemable_type');
            $table->integer('itemable_id');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->json('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine_order_items');
    }
};
