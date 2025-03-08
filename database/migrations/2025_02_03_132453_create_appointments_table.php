<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();  
            $table->string('name');  
            $table->string('email');  
            $table->string('phone');  
            $table->string('class');  
            $table->date('appointment_date'); 
            $table->time('appointment_time'); 
            $table->text('remark')->nullable();  
            $table->timestamps();  
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
