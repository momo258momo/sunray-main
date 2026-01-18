<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * Cho phép mass assignment
     */
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',

        // GIỮ NGUYÊN THEO DB
        'category',
        'shape',
        'material',
        'color',
        'frame_size',

        'price',
        'sale_percent',
        'stock_quantity',

        'image_url',
        'is_featured',
        'on_sale',
    ];

    /**
     * Cast kiểu dữ liệu
     */
    protected $casts = [
        'price' => 'float',
        'sale_percent' => 'integer',
        'stock_quantity' => 'integer',
        'is_featured' => 'boolean',
        'on_sale' => 'boolean',
    ];

    /**
     * Ảnh phụ sản phẩm
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Scope filter (dùng cho trang danh sách)
     */
    public function scopeFilter(
        Builder $query,
        ?string $search = null,
        ?string $category = null,
        ?string $shape = null,
        ?string $color = null
    ): Builder {

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($shape)) {
            $query->where('shape', $shape);
        }

        if (!empty($color)) {
            $query->where('color', 'like', '%' . $color . '%');
        }

        return $query;
    }

    /**
     * Giá sau giảm (%)
     */
    public function getFinalPriceAttribute()
    {
        if ($this->on_sale && $this->sale_percent > 0) {
            return $this->price * (1 - $this->sale_percent / 100);
        }

        return $this->price;
    }
}
