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
            $table->foreignId('health_plan_id')->constrained('health_plans')->onDelete('cascade');
            $table->boolean('type')->default(0);
            $table->json('plan_data');
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
