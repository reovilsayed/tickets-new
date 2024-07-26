<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('type')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->decimal('sale_price',8,2)->nullable();
            $table->integer('total_sale')->nullable();
            $table->decimal('vendor_price',8,2)->nullable();
            $table->text('downloads')->nullable();
            $table->boolean('manage_stock')->default(false);
            $table->integer('quantity')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('rating_count')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->tinyInteger('is_offer')->nullable();
            $table->json('variations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};