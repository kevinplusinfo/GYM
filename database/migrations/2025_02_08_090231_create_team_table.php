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
    Schema::create('trainers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email',191)->unique();
        $table->string('phone')->nullable();
        $table->integer('experience')->nullable();
        $table->text('expertise')->nullable();
        $table->text('remark')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team');
    }
};
