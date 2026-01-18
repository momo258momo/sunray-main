@extends('admin.layout')

@section('content')
    <h2>Báo cáo và Thống kê</h2>
    <p>Tổng số người dùng: {{ $totalUsers }}</p>
    <p>Tổng số sản phẩm: {{ $totalProducts }}</p>
    <p>Tổng số đơn hàng: {{ $totalOrders }}</p>
@endsection