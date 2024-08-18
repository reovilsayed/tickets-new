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
        Schema::create('invite_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invite_id');
            $table->foreignId('product_id');
            $table->integer('quantity')->default(0);
            $table->integer('used')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invite_product');
    }
};
