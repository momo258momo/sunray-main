@extends('layouts.app')

@section('title', 'Chi tiết Đơn hàng #' . $order->order_number)

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">

            <h4 class="mb-4">Chi tiết Đơn hàng #{{ $order->order_number }}</h4>

            {{-- THÔNG TIN CHUNG --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    Thông tin chung
                </div>
                <div class="card-body">
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge {{ $order->status === \App\Models\Order::DELIVERED ? 'bg-success' : 'bg-primary' }}">
                            {{ $order->status_label }}
                        </span>
                    </p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
                    <p>
                        <strong>Tổng tiền:</strong>
                        <span class="fw-bold text-danger">
                            {{ number_format($order->total, 0, ',', '.') }} VNĐ
                        </span>
                    </p>
                </div>
            </div>

            {{-- DANH SÁCH SẢN PHẨM --}}
            <h5 class="mb-3">Sản phẩm đã đặt</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end">Đơn giá</th>
                        <th class="text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">
                                {{ number_format($item->price, 0, ',', '.') }} VNĐ
                            </td>
                            <td class="text-end fw-bold">
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ================== ĐÁNH GIÁ ================== --}}
            @php
                $hasUnreviewedItems = $order->orderItems->contains(function ($item) {
                    return !$item->review;
                });
            @endphp

            @if(
                $order->status === \App\Models\Order::DELIVERED &&
                $hasUnreviewedItems
            )
                <h5 class="mt-4">⭐ Đánh giá sản phẩm</h5>

                <form action="{{ route('reviews.storeMultiple') }}" method="POST">
                    @csrf

                    @include('partials._rating_items')

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            Gửi đánh giá
                        </button>
                    </div>
                </form>
            @elseif($order->status === \App\Models\Order::DELIVERED)
                <p class="text-success mt-4">
                    ✔ Bạn đã đánh giá tất cả sản phẩm trong đơn hàng này
                </p>
            @endif

            {{-- ================== ACTION ================== --}}
            <div class="text-end mt-4">
                @if($order->status === \App\Models\Order::SHIPPING)

                    <form action="{{ route('orders.received', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Đã nhận được hàng
                        </button>
                    </form>

                    <form action="{{ route('orders.return', $order->id) }}"
                          method="POST"
                          class="d-inline ms-2"
                          onsubmit="return confirm('Bạn có chắc chắn muốn trả hàng?');">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            Trả hàng
                        </button>
                    </form>

                
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
