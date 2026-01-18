<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Các cột được phép fill (dùng guarded rỗng cho nhanh)
     */
    protected $guarded = [];

    /**
     * OrderItem thường không cần timestamps
     */
    public $timestamps = false;

    /* ================== RELATIONSHIPS ================== */

    /**
     * Sản phẩm của item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)
            ->select(['id', 'name', 'slug', 'image_url']);
    }

    /**
     * Review cho sản phẩm (sau khi mua)
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Yêu cầu trả hàng cho từng item
     */
    public function returnRequest(): HasOne
    {
        return $this->hasOne(ReturnRequest::class);
        // mặc định Laravel sẽ tìm:
        // return_requests.order_item_id
    }
}
