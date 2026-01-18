<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::filter(
            $request->search,
            $request->category,
            $request->shape,
            $request->color
        );

        $products = $query
            ->orderByRaw('stock_quantity > 0 DESC')
            ->paginate(15)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(string $slug): View
    {
        $product = Product::with('images')
            ->where('slug', $slug)
            ->firstOrFail();

        /* ================= IMAGES ================= */
        $images = [];

        if ($product->image_url) {
            $images[] = asset($product->image_url);
        }

        foreach ($product->images as $img) {
            $images[] = asset($img->image_path);
        }

        /* ================= STOCK & PRICE ================= */
        $stock = $product->stock_quantity;

        $hasSale = $product->on_sale
            && $stock > 0
            && $product->sale_percent > 0;

        $salePercent = $product->sale_percent ?? 0;

        $finalPrice = $hasSale
            ? $product->price * (1 - $salePercent / 100)
            : $product->price;

        /* ================= REVIEWS ================= */
        $reviews = Review::where('product_id', $product->id)
            ->latest()
            ->get();

        $avgRating = $reviews->count()
            ? round($reviews->avg('rating'), 1)
            : 0;

        /* ================= SOLD ================= */
        $sold = DB::table('order_items')
            ->where('product_id', $product->id)
            ->sum('quantity');

        /* ================= RELATED ================= */
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product',
            'images',
            'stock',
            'hasSale',
            'salePercent',
            'finalPrice',
            'reviews',
            'avgRating',
            'sold',
            'relatedProducts'
        ));
    }
}
