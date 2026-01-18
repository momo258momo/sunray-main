@extends('admin.layout')

@section('content')
    <h2>Quản lý Đơn hàng</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Tổng tiền</th>
                <th>Tình trạng</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>

                    <td>
                        <span class="badge
                            @if (in_array($order->status, [
                                \App\Models\Order::CANCELLED,
                                \App\Models\Order::RETURN_REJECTED
                            ]))
                                bg-danger
                            @elseif ($order->status === \App\Models\Order::DELIVERED)
                                bg-success
                            @elseif (in_array($order->status, [
                                \App\Models\Order::RETURN_PENDING,
                                \App\Models\Order::RETURN_APPROVED
                            ]))
                                bg-info
                            @else
                                bg-warning
                            @endif
                        ">
                            {{ $order->status_label }}
                        </span>
                    </td>

                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="btn btn-info btn-sm">
                            Xem
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endsection
