<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Các trường có thể được gán hàng loạt (Mass Assignable)
    protected $fillable = [
        'user_id',
        'product_id',
        'order_item_id',
        'rating',
        'comment',
    ];

    /**
     * Quan hệ: Một đánh giá thuộc về một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ: Một đánh giá thuộc về một sản phẩm.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ: Một đánh giá thuộc về một mục đơn hàng.
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}