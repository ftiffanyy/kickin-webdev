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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('detail_price_at_purchase', 10, 2);
            $table->integer('detail_qty');
            $table->tinyInteger('detail_status_del')->default(0);
            $table->foreign('variant_id')->references('variant_id')->on('variants')->onDelete('cascade');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
