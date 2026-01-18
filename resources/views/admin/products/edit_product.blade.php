@extends('admin.layout')

@section('title', 'Sửa sản phẩm')

@section('content')

<h2>Sửa Sản Phẩm</h2>

{{-- HIỂN THỊ LỖI --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="admin-form"
      action="{{ route('admin.products.update', $product->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- TÊN --}}
    <label for="name">Tên sản phẩm:</label>
    <input type="text" name="name" id="name"
           value="{{ old('name', $product->name) }}" required>

    {{-- MÔ TẢ NGẮN --}}
    <label for="short_description">Mô tả ngắn:</label>
    <input type="text" name="short_description" id="short_description"
           value="{{ old('short_description', $product->short_description) }}">

    {{-- MÔ TẢ DÀI --}}
    <label for="long_description">Mô tả dài:</label>
    <textarea name="long_description" id="long_description" rows="6">{{ old('long_description', $product->long_description) }}</textarea>

    {{-- DANH MỤC --}}
    <label for="category">Danh mục:</label>
    <select name="category" id="category" required>
        <option value="glasses"
            {{ old('category', $product->category) === 'glasses' ? 'selected' : '' }}>
            Kính
        </option>
        <option value="sunglasses"
            {{ old('category', $product->category) === 'sunglasses' ? 'selected' : '' }}>
            Kính râm
        </option>
    </select>

    {{-- DÁNG KÍNH --}}
    <label for="shape">Dáng kính:</label>
    <select name="shape" id="shape" required>
        @php $shape = old('shape', $product->shape); @endphp
        <option value="square" {{ $shape === 'square' ? 'selected' : '' }}>Gọng vuông</option>
        <option value="rectangle" {{ $shape === 'rectangle' ? 'selected' : '' }}>Gọng chữ nhật</option>
        <option value="round" {{ $shape === 'round' ? 'selected' : '' }}>Gọng tròn</option>
        <option value="oval" {{ $shape === 'oval' ? 'selected' : '' }}>Gọng oval</option>
        <option value="cat-eye" {{ $shape === 'cat-eye' ? 'selected' : '' }}>Gọng mắt mèo</option>
        <option value="aviator" {{ $shape === 'aviator' ? 'selected' : '' }}>Gọng phi công</option>
        <option value="polygon" {{ $shape === 'polygon' ? 'selected' : '' }}>Gọng đa giác</option>
        <option value="semi-rimless" {{ $shape === 'semi-rimless' ? 'selected' : '' }}>Gọng nửa viền</option>
    </select>

    {{-- CHẤT LIỆU --}}
    <label for="material">Chất liệu:</label>
    <input type="text" name="material" id="material"
           value="{{ old('material', $product->material) }}">

    {{-- MÀU --}}
    <label for="color">Màu sắc:</label>
    <input type="text" name="color" id="color"
           value="{{ old('color', $product->color) }}">

    {{-- KÍCH THƯỚC GỌNG (DB CÓ) --}}
    <label for="frame_size">Kích thước gọng:</label>
    <input type="text" name="frame_size" id="frame_size"
           value="{{ old('frame_size', $product->frame_size) }}">

    {{-- GIÁ --}}
    <label for="price">Giá:</label>
    <input type="number" name="price" id="price"
           value="{{ old('price', $product->price) }}" required>

    {{-- SỐ LƯỢNG --}}
    <label for="stock_quantity">Số lượng trong kho:</label>
    <input type="number" name="stock_quantity" id="stock_quantity"
           value="{{ old('stock_quantity', $product->stock_quantity) }}" required>

    {{-- ẢNH CHÍNH --}}
    <label>Ảnh đại diện hiện tại:</label><br>
    <img src="{{ asset($product->image_url) }}" width="120" style="margin-bottom:10px">

    <label for="image">Đổi ảnh đại diện:</label>
    <input type="file" name="image" id="image">

    {{-- ẢNH PHỤ --}}
    <label for="images">Thêm ảnh chi tiết:</label>
    <input type="file" name="images[]" id="images" multiple>

    {{-- CHECKBOX --}}
    <div class="checkbox-group">
        <input type="checkbox" name="is_featured" id="is_featured" value="1"
            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
        <label for="is_featured">Nổi bật</label>
    </div>


{{-- ON SALE --}}
<input type="hidden" name="on_sale" value="0">
<div class="checkbox-group">
    <input type="checkbox" name="on_sale" id="on_sale" value="1"
        {{ old('on_sale', $product->on_sale) ? 'checked' : '' }}>
    <label for="on_sale">Đang giảm giá</label>
</div>

<div class="sale-box">
    <label for="sale_percent">Giảm bao nhiêu %</label>
    <input type="number" name="sale_percent"
           value="{{ old('sale_percent', $product->sale_percent) }}"
           min="1" max="90">
</div>



    <button type="submit">Cập nhật sản phẩm</button>
</form>

<hr>

<h3>Ảnh chi tiết</h3>

<div class="image-grid">
    @foreach ($product->images as $img)
        <div class="image-box">
            <img src="{{ asset($img->image_path) }}">

            <form action="{{ route('admin.product-images.destroy', $img->id) }}"
                  method="POST"
                  onsubmit="return confirm('Xóa ảnh này?')">
                @csrf
                @method('DELETE')
                <button class="delete-btn">×</button>
            </form>
        </div>
    @endforeach
</div>

@endsection
