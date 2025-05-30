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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionable_id');
            $table->string('transactionable_type');
            $table->enum('type', ['credit', 'debit']);
            $table->string('key')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->default(0);
            $table->foreignId('agent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
