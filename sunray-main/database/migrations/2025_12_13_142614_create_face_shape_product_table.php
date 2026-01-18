<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_shape_product', function (Blueprint $table) {
            // Khóa ngoại liên kết tới bảng face_shapes
            $table->foreignId('face_shape_id')->constrained()->onDelete('cascade');
            
            // Khóa ngoại liên kết tới bảng products
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Thiết lập khóa chính tổng hợp để đảm bảo tính duy nhất
            $table->primary(['face_shape_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_shape_product');
    }
};