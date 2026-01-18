<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            // Khóa chính tự tăng
            $table->id();

            // Khóa ngoại liên kết với bảng 'orders'
            $table->foreignId('order_id')
                  ->constrained() // Giả sử bảng orders tồn tại
                  ->cascadeOnDelete(); // Xóa yêu cầu trả hàng nếu đơn hàng bị xóa

            // Khóa ngoại liên kết với bảng 'order_items'
            // Giả sử bảng order_items tồn tại
            $table->foreignId('order_item_id')
                  ->constrained() 
                  ->cascadeOnDelete(); // Xóa yêu cầu trả hàng nếu mục đơn hàng bị xóa

            // Lý do trả hàng (text cho nội dung dài hơn)
            $table->text('reason');

            // Đường dẫn hình ảnh minh chứng (có thể null)
            $table->string('image')->nullable();

            // Trạng thái yêu cầu trả hàng: pending | approved | rejected
            $table->string('status')->default('pending'); 

            // Tự động tạo cột created_at và updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};