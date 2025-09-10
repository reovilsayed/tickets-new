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
        Schema::table('subscription_records', function (Blueprint $table) {
            $table->unsignedBigInteger('magazine_order_id')->nullable()->after('subscription_id');

            // If you want a foreign key constraint
            $table->foreign('magazine_order_id')
                ->references('id')
                ->on('magazine_orders')
                ->onDelete('set null'); // or cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_records', function (Blueprint $table) {
            $table->dropForeign(['magazine_order_id']);
            $table->dropColumn('magazine_order_id');
        });
    }
};
