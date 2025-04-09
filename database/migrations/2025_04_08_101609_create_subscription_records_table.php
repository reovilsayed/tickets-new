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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('magazine_subscription_id')
                ->nullable()
                ->constrained('magazine_subscriptions')
                ->onDelete('cascade');

            $table->foreignId('magazine_order_item_id')
                ->nullable()
                ->constrained('magazine_order_items')
                ->onDelete('cascade');

            $table->foreignId('magazine_id')
                ->constrained('magazines')
                ->onDelete('cascade');

            $table->enum('subscription_type', ['digital', 'physical']);
            $table->string('recurring_period');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->json('details')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_records');
    }
};
