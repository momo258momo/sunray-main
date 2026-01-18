<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('face_shape_glass_shapes', function (Blueprint $table) {
            $table->id();
            $table->string('face_shape', 20);
            $table->string('glass_shape', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_shape_glass_shapes');
    }
};

