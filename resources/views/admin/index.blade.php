@extends('admin.layout')

@section('content')
    <div class="container">
        <h1>Welcome to Admin Dashboard</h1>
        <p>Đây là trang quản trị của bạn.</p>

        <div class="statistics">
            <h2>Thống kê nhanh</h2>
            <ul>
                <li>Tổng số người dùng: {{ $totalUsers }}</li>
                <li>Tổng số sản phẩm: {{ $totalProducts }}</li>
                <li>Tổng số đơn hàng: {{ $totalOrders }}</li>
            </ul>
        </div>

        <div class="actions">
            <h2>Hành động nhanh</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Quản lý Người dùng</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quản lý Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Quản lý Đơn hàng</a>
        </div>
    </div>
@endsection