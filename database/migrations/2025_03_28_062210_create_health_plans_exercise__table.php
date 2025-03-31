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
        Schema::create('health_plans_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('goal');
            $table->decimal('current_weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->integer('age');
            $table->string('activity_level');
            $table->string('work');
            $table->string('dailyroutin');
            $table->json('plans');
            $table->boolean('is_selected')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_plans_exercises');
    }
};
