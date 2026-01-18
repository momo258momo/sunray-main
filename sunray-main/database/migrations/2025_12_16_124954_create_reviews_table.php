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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại liên kết với người dùng (users)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Khóa ngoại liên kết với sản phẩm (products)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Khóa ngoại liên kết với mục đơn hàng (order_items)
            // Đảm bảo mỗi mục hàng chỉ được đánh giá 1 lần
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade')->unique();
            
            // Số sao đánh giá (1-5)
            $table->unsignedTinyInteger('rating'); 
            
            // Nội dung bình luận
            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};