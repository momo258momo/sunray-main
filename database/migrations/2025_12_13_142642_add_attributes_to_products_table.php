<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Yêu cầu bổ sung: Thêm Số lượng tồn kho
            $table->integer('stock_quantity')->after('price')->default(0);

            // Các thuộc tính quan trọng cho việc gợi ý của AI
            $table->string('shape')->after('category')->nullable(); // Hình dáng gọng (ví dụ: 'round', 'cat-eye')
            $table->string('material')->after('shape')->nullable(); // Chất liệu (ví dụ: 'metal', 'acetate')
            $table->string('color')->after('material')->nullable(); // Màu sắc (ví dụ: 'black', 'gold')
            $table->string('frame_size')->after('color')->nullable(); // Kích thước (ví dụ: '50-20-145')
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock_quantity', 'shape', 'material', 'color', 'frame_size']);
        });
    }
};
