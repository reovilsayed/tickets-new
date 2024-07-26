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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->tinyInteger('status')->default(0)->comment('0=pending 1=paid 2=on its way 3=cancle 4=delivered');
            $table->string('currency', 5)->nullable();
            $table->integer('discount')->nullable();
            $table->integer('discount_code')->nullable();
            $table->integer('shipping_total')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('shipping_url')->nullable();
            $table->integer('subtotal');
            $table->integer('total');
            $table->integer('vendor_total');
            $table->boolean('seen', false);
            $table->integer('tax')->nullable();
            $table->string('customer_note')->nullable();
            $table->json('billing')->nullable();
            $table->json('shipping');
            $table->string('payment_method')->nullable();
            $table->string('payment_method_title')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('date_paid')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->string('refund_amount')->nullable();
            $table->string('company')->nullable();
            $table->string('aptment')->nullable();
            $table->integer('quantity');

            $table->bigInteger('parent_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('orders');
    }
};