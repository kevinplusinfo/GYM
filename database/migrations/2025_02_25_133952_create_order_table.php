<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->decimal('amount', 10, 2);
            $table->string('razorpay_order_id', 191)->unique(); // Fixed: Limited length
            $table->string('razorpay_payment_id', 191)->nullable();
            $table->string('razorpay_signature', 191)->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Failed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
