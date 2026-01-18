<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceShape extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
    ];

    /**
     * Get the route key for the model.
     * Thường dùng để tìm kiếm FaceShape qua slug thay vì ID
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

 
    public function products()
    {

        return $this->belongsToMany(Product::class);
    }
    
// // Tìm dáng mặt theo tên (hoặc slug)
// $ovalShape = \App\Models\FaceShape::where('slug', 'oval')->first();

// if ($ovalShape) {
//     // Lấy tất cả các sản phẩm phù hợp với dáng mặt này
//     $recommendedProducts = $ovalShape->products()->get();
    
//     // Bạn có thể hiển thị ảnh minh họa dáng mặt:
//     // echo $ovalShape->image_url; 
// }
}