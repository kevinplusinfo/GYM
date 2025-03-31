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
        Schema::create('selected_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Stores which user selected the plan
            $table->foreignId('health_plan_id')->constrained('health_plans_exercise')->onDelete('cascade'); 
            $table->integer('plan_no')->nullable(); // Stores plan number
            $table->boolean('ischeck')->default(0); // Checkbox value (e.g., push notifications)
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_plans');
    }
};
