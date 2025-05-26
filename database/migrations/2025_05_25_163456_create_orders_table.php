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
            $table->id();
            $table->timestamp('date')->useCurrent();
            $table->decimal('total_price', 10, 2);
            $table->integer('total_qty');
            $table->enum('status', ['Pick Up', 'Shipping'])->default('shipping');
            $table->text('shipping_address')->nullable();
            $table->enum('shipping_status', ['Pending', 'Dispatched', 'In Transit', 'Delivered', 'Already Pick Up'])->default('Pending');
            
            // Tambahan
            $table->string('invoice_number')->unique(); 
            $table->text('payment_url')->nullable();    

            // Foreign key ke users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
