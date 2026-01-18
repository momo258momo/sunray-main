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
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();

            // liên kết đơn hàng
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // người tạo yêu cầu trả hàng
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // lý do trả hàng
            $table->string('reason');

            // phương thức hoàn tiền (ví / ngân hàng)
            $table->string('refund_method');

            // phương thức hoàn hàng (người đến lấy / gửi bưu cục)
            $table->string('return_method');

            // danh sách sản phẩm trả (id order_items)
            $table->json('items');

            // ghi chú thêm của khách
            $table->text('note')->nullable();

            // trạng thái xử lý yêu cầu
            $table->enum('status', [
                'pending',      // chờ duyệt
                'approved',     // đã chấp nhận
                'rejected',     // từ chối
                'completed'     // đã hoàn tất trả hàng & hoàn tiền
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
