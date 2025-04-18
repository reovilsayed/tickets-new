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
        Schema::create('magazine_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magazine_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->integer('discount');
            $table->date('expire_at');
            $table->integer('limit');
            $table->tinyInteger('used');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine_coupons');
    }
};
