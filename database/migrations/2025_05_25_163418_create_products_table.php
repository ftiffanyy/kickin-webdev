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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->decimal('product_cogs', 10, 2);
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_discount', 5, 2)->default(0);
            $table->string('product_brand');
            $table->enum('product_gender', ['male', 'female', 'unisex'])->default('unisex');
            $table->text('product_description')->nullable();
            $table->decimal('product_rating_avg', 3, 2)->default(0);
            $table->integer('product_total_reviews')->default(0);
            $table->integer('product_sold')->default(0);
            $table->boolean('product_hide_status')->default(false);
            $table->tinyInteger('product_status_del')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
