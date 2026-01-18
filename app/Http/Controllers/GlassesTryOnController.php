<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class GlassesTryOnController extends Controller
{
    /**
     * Hiển thị form thử kính
     */
    public function showForm()
    {
        return view('glasses_try_on.form');
    }

    /**
     * Xử lý POST thử kính
     */
    public function process(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'face_image' => 'required|image|max:5120', // max 5MB
            'shape' => 'required|string',
            'color' => 'required|string',
        ]);

        $file = $request->file('face_image');

        try {
            // Gửi file sang Flask API
            $response = Http::attach(
                'face_image',
                fopen($file->getRealPath(), 'r'),
                $file->getClientOriginalName()
            )->post('http://127.0.0.1:5001/try-on', [
                'shape' => $request->shape,
                'color' => $request->color,
            ]);

            // Kiểm tra Flask trả về thành công
            if ($response->successful()) {

                // Lưu ảnh vào storage/public/results
                $filename = 'results/' . time() . '_result.png';
                Storage::disk('public')->put($filename, $response->body());

                // Tạo URL đầy đủ cho Blade hiển thị
                $result_url = url('storage/' . $filename);

                // Lấy các sản phẩm gợi ý (ví dụ: cùng loại kính)
                $recommendedProducts = Product::where('category', 'glasses')
                                              ->take(4)
                                              ->get();

                // Trả view với cả result_image và recommendedProducts
                return view('glasses_try_on.result', [
                    'result_image' => $result_url,
                    'recommendedProducts' => $recommendedProducts,
                ]);
            }

            // Nếu Flask trả về lỗi
            return back()->withErrors(['msg' => 'Flask API không trả kết quả. Status: '.$response->status()]);

        } catch (\Exception $e) {
            // Bắt lỗi request hoặc lưu file
            return back()->withErrors(['msg' => 'Lỗi server: ' . $e->getMessage()]);
        }
    }

    /**
     * Hiển thị kết quả (nếu muốn dùng route riêng)
     */
    public function result(Request $request)
    {
        $result_image = session('result_image'); // hoặc truyền từ process

        $recommendedProducts = Product::where('category', 'glasses')
                                      ->take(4)
                                      ->get();

        return view('glasses_try_on.result', [
            'result_image' => $result_image,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
