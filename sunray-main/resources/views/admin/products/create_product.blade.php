@extends('admin.layout')

@section('title', 'Thêm sản phẩm')

@section('content')

<h2>Thêm Sản Phẩm</h2>

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
      action="{{ route('admin.products.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    {{-- TÊN --}}
    <label for="name">Tên sản phẩm:</label>
    <input type="text" name="name" id="name"
           value="{{ old('name') }}" required>

    {{-- MÔ TẢ NGẮN --}}
    <label for="short_description">Mô tả ngắn:</label>
    <input type="text" name="short_description" id="short_description"
           value="{{ old('short_description') }}">

    {{-- MÔ TẢ DÀI --}}
    <label for="long_description">Mô tả dài:</label>
    <textarea name="long_description" id="long_description" rows="6">{{ old('long_description') }}</textarea>

    {{-- DANH MỤC --}}
    <label for="category">Danh mục:</label>
    <select name="category" id="category" required>
        <option value="glasses" {{ old('category') === 'glasses' ? 'selected' : '' }}>Kính</option>
        <option value="sunglasses" {{ old('category') === 'sunglasses' ? 'selected' : '' }}>Kính râm</option>
    </select>

    {{-- DÁNG KÍNH --}}
    <label for="shape">Dáng kính:</label>
    <select name="shape" id="shape" required>
        @php $shape = old('shape'); @endphp
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
           value="{{ old('material') }}">

    {{-- MÀU --}}
    <label for="color">Màu sắc:</label>
    <input type="text" name="color" id="color"
           value="{{ old('color') }}">

    {{-- KÍCH THƯỚC GỌNG --}}
    <label for="frame_size">Kích thước gọng:</label>
    <input type="text" name="frame_size" id="frame_size"
           value="{{ old('frame_size') }}">

    {{-- GIÁ --}}
    <label for="price">Giá:</label>
    <input type="number" name="price" id="price" min="0"
           value="{{ old('price') }}" required>

    {{-- SỐ LƯỢNG --}}
    <label for="stock_quantity">Số lượng trong kho:</label>
    <input type="number" name="stock_quantity" id="stock_quantity" min="0"
           value="{{ old('stock_quantity') }}">

    {{-- ẢNH CHÍNH --}}
    <label for="image">Ảnh đại diện:</label>
    <input type="file" name="image" id="image" required>

    {{-- ẢNH PHỤ --}}
    <label for="images">Ảnh chi tiết:</label>
    <input type="file" name="images[]" id="images" multiple>

    {{-- CHECKBOX NỔI BẬT --}}
    <div class="checkbox-group">
        <input type="checkbox" name="is_featured" id="is_featured" value="1"
            {{ old('is_featured') ? 'checked' : '' }}>
        <label for="is_featured">Nổi bật</label>
    </div>

    {{-- CHECKBOX GIẢM GIÁ --}}
    <input type="hidden" name="on_sale" value="0">
    <div class="checkbox-group">
        <input type="checkbox" name="on_sale" id="on_sale" value="1"
            {{ old('on_sale') ? 'checked' : '' }}>
        <label for="on_sale">Đang giảm giá</label>
    </div>

    <div class="sale-box">
        <label for="sale_percent">Giảm bao nhiêu %</label>
        <input type="number" name="sale_percent"
               value="{{ old('sale_percent') }}"
               min="1" max="90">
    </div>

    <button type="submit">Thêm sản phẩm</button>
</form>

@endsection
