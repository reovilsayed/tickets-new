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
        Schema::create('subscription_magazine_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magazine_subscription_id')
                ->constrained('magazine_subscriptions')
                ->onDelete('cascade');
            $table->foreignId('magazine_id') 
                ->constrained('magazines') 
                ->onDelete('cascade'); 
            $table->enum('subscription_type', ['physical', 'digital']);
            $table->decimal('price', 10, 2);
            $table->string('recurring_period');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_magazine_details');
    }
};
