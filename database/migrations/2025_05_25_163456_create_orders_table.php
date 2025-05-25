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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('order_date')->useCurrent();
            $table->decimal('order_total_price', 10, 2);
            $table->integer('order_total_qty');
            $table->enum('order_status', ['pickup', 'shipping'])->default('shipping');
            $table->text('order_shipping_address');
            $table->enum('order_shipping_status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->tinyInteger('order_status_del')->default(0);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
