<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.products', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create_product');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit_product', compact('product'));
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',

            'category' => 'required|in:glasses,sunglasses',
            'shape' => 'required|in:square,rectangle,round,oval,cat-eye,aviator,polygon,semi-rimless',

            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'frame_size' => 'nullable|string|max:50',

            'price' => 'required|numeric|min:1000',
            'stock_quantity' => 'required|integer|min:0',

            'on_sale' => 'nullable|boolean',
            'sale_percent' => 'nullable|integer|min:1|max:90',
            'is_featured' => 'nullable|boolean',

            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ảnh đại diện
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = 'images/' . time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), basename($imagePath));
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),

            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'category' => $request->category,
            'shape' => $request->shape,
            'material' => $request->material,
            'color' => $request->color,
            'frame_size' => $request->frame_size,

            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,

            'on_sale' => $request->on_sale ?? 0,
            'sale_percent' => $request->on_sale ? $request->sale_percent : null,
            'is_featured' => $request->is_featured ?? 0,

            'image_url' => $imagePath,
        ]);

        // ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $path = 'images/products/' . time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('images/products'), basename($path));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm sản phẩm');
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',

            'category' => 'required|in:glasses,sunglasses',
            'shape' => 'required|in:square,rectangle,round,oval,cat-eye,aviator,polygon,semi-rimless',

            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'frame_size' => 'nullable|string|max:50',

            'price' => 'required|numeric|min:1000',
            'stock_quantity' => 'required|integer|min:0',

            'on_sale' => 'nullable|boolean',
            'sale_percent' => 'nullable|integer|min:1|max:90',
            'is_featured' => 'nullable|boolean',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image_url;

        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            $imagePath = 'images/' . time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), basename($imagePath));
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),

            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'category' => $request->category,
            'shape' => $request->shape,
            'material' => $request->material,
            'color' => $request->color,
            'frame_size' => $request->frame_size,

            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,

            'on_sale' => $request->on_sale ?? 0,
            'sale_percent' => $request->on_sale ? $request->sale_percent : null,
            'is_featured' => $request->is_featured ?? 0,

            'image_url' => $imagePath,
        ]);

        // thêm ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $path = 'images/products/' . time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('images/products'), basename($path));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã cập nhật sản phẩm');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url && file_exists(public_path($product->image_url))) {
            unlink(public_path($product->image_url));
        }

        foreach ($product->images as $img) {
            if (file_exists(public_path($img->image_path))) {
                unlink(public_path($img->image_path));
            }
        }

        $product->delete();

        return back()->with('success', 'Đã xóa sản phẩm');
    }
}
