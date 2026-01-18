<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class GlassesSuggestController extends Controller
{
    public function index()
    {
        return view('glasses_suggest.index');
    }

    public function create()
    {
        return view('glasses_suggest.detect');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validate ảnh
        $request->validate([
            'face_image' => 'required|image|max:5120',
        ]);

        // 2️⃣ Gửi ảnh sang AI
        try {
            $response = Http::timeout(20)
                ->attach(
                    'file',
                    fopen($request->file('face_image')->getPathname(), 'r'),
                    $request->file('face_image')->getClientOriginalName()
                )
                ->post(config('services.face_ai.endpoint'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'ai' => 'Không thể kết nối tới hệ thống AI.'
            ]);
        }

        if (!$response->successful()) {
            return back()->withErrors([
                'ai' => 'Không thể nhận diện khuôn mặt.'
            ]);
        }

        // 3️⃣ Nhận kết quả AI
        $result = $response->json();

        $faceShape  = $result['face_shape'] ?? null;
        $confidence = $result['confidence'] ?? 0;

        if (!$faceShape) {
            return back()->withErrors([
                'ai' => 'AI không trả về dáng khuôn mặt.'
            ]);
        }

        // 4️⃣ Mapping tiếng Việt (CHUẨN MVC)
        $faceShapeVi = [
            'oval'   => 'Mặt trái xoan',
            'round'  => 'Mặt tròn',
            'square' => 'Mặt vuông',
            'heart'  => 'Mặt trái tim',
            'oblong' => 'Mặt dài',
        ];

        $glassShapeVi = [
            'square'        => 'Gọng vuông',
            'rectangle'    => 'Gọng chữ nhật',
            'round'         => 'Gọng tròn',
            'oval'          => 'Gọng oval',
            'aviator'       => 'Gọng phi công',
            'polygon'       => 'Gọng đa giác',
            'semi-rimless'  => 'Gọng nửa viền',
            'cat-eye'       => 'Gọng mắt mèo',
        ];

        // 5️⃣ Lấy gọng kính phù hợp từ DB
        $glassShapes = DB::table('face_shape_glass_shapes')
            ->where('face_shape', $faceShape)
            ->pluck('glass_shape')
            ->toArray();

        // 6️⃣ Lấy sản phẩm kính
        $products = Product::whereIn('shape', $glassShapes)
            ->where('stock_quantity', '>', 0)
            ->orderByDesc('is_featured')
            ->orderByDesc('stock_quantity')
            ->limit(8)
            ->get();

        // 7️⃣ Trả view
        return view('glasses_suggest.result', compact(
            'faceShape',
            'confidence',
            'glassShapes',
            'products',
            'faceShapeVi',
            'glassShapeVi'
        ));
    }
}
