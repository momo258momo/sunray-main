<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Xóa ảnh phụ của sản phẩm
     */
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // Xóa file trong public
        if ($image->image_path && file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Xóa record DB
        $image->delete();

        return back()->with('success', 'Đã xóa ảnh thành công.');
    }
}
