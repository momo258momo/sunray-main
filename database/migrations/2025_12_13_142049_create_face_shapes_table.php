<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_shapes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('slug')->unique();
            $table->text('description')->nullable(); 
            $table->string('image_url')->nullable(); // Ảnh minh họa cho dáng mặt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_shapes');
    }
};