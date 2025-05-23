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
        Schema::create('subscription_records', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('recordable_id')->nullable();
            $table->string('recordable_type')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('magazine_id')->nullable();
            $table->foreignId('subscription_id')->nullable();
            $table->enum('subscription_type', ['digital', 'physical'])->nullable();
            $table->string('recurring_period')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('details')->nullable();
            $table->json('shipping_info')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_records');
    }
};
