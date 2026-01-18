@extends('admin.layout')

@section('content')

<style>

</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý Sản phẩm</h2>
    
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="fas fa-plus me-1"></i>
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-bordered table-product-management">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                <td>
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                </td>

                <td>{{ $product->name }}</td>

                <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>

                <td>
                    @if ($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                        <span class="badge bg-warning text-dark">
                            Sắp hết ({{ $product->stock_quantity }})
                        </span>
                    @elseif ($product->stock_quantity == 0)
                        <span class="badge bg-danger">
                            Hết hàng (0)
                        </span>
                    @else
                        <span class="badge bg-success">
                            {{ $product->stock_quantity }}
                        </span>
                    @endif
                </td>

                <td>
                    {{-- ✅ FIX: dùng ID --}}
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="btn btn-warning btn-sm">
                        Sửa
                    </a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Xóa sản phẩm này?')">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
