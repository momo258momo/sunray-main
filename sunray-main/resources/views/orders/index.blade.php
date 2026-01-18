@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')

{{-- ✅ KHUYẾN NGHỊ: Thêm phần hiển thị thông báo flash message --}}
<div class="container mt-5 pb-5">

    {{-- Hiển thị thông báo thành công (Success) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Hiển thị thông báo lỗi (Error) --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
{{-- ✅ HẾT PHẦN THÔNG BÁO --}}

    <div class="row">
        <div class="col-lg-3">
            @include('partials.sidebar')
        </div>

        <div class="col-lg-9">
            <h4 class="mb-3">Đơn hàng của tôi</h4>

            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 50rem;">
                    <thead class="small">
                        <tr>
                            <th>Đơn hàng #</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>

                            <td>{{ $order->created_at->format('d/m/Y') }}</td>

                            <td>
                                {{-- LOGIC THÊM MÀU TRẠNG THÁI --}}
                                @php
                                    $badgeClass = 'bg-primary'; // Mặc định là primary (xanh dương)
                                    switch ($order->status) {
                                        case 'pending':
                                            $badgeClass = 'bg-primary';
                                            break;
                                        case 'processing':
                                            $badgeClass = 'bg-warning text-dark'; // Cần text-dark cho nền vàng
                                            break;
                                        case 'shipped':
                                        case 'delivered':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'cancelled':
                                            $badgeClass = 'bg-danger';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary';
                                            break;
                                    }
                                @endphp
                                
                                <span class="badge {{ $badgeClass }} fw-normal">
                                    {{ $order->status_label }}
                                </span>
                                {{-- HẾT LOGIC THÊM MÀU TRẠNG THÁI --}}
                            </td>

                            <td>{{ $order->address }}</td>

                            <td class="fw-bold text-danger">
                                {{ number_format($order->total, 0, ',', '.') }} VNĐ
                            </td>

                            <td class="text-end text-nowrap"> 
                                
                                {{-- 1. NÚT XEM --}}
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    Xem
                                </a>

                                {{-- 2. NÚT HỦY ĐƠN --}}
                                @if($order->status === 'pending') 
                                <form action="{{ route('orders.cancel', $order->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->order_number }} này không?');">
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hủy  
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                {{ $orders->links() }}
            </div>

            @else
                <p class="text-muted">Không tìm thấy đơn hàng nào</p>
            @endif
        </div>
    </div>
</div>

@endsection