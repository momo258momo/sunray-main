@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Chi tiết Đơn hàng #{{ $order->order_number }}</h2>
            <p>Khách hàng: {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
            <p>Số điện thoại: {{ $order->phone_number }}</p>
            <p>Địa chỉ: {{ $order->address }}</p>
            <p>Ghi chú: {{ $order->order_notes ?? 'Không có ghi chú' }}</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            {{-- FORM CẬP NHẬT TRẠNG THÁI --}}
            <div class="card">
                <div class="card-header">Cập nhật Trạng thái</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Sử dụng phương thức PUT cho cập nhật --}}

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái hiện tại:</label>
                            <select name="status" id="status" class="form-control">
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{-- THÔNG TIN TỔNG KẾT --}}
            <div class="card">
                <div class="card-header">Tổng kết Đơn hàng</div>
                <div class="card-body">
                    <p><strong>Trạng thái:</strong> <span class="badge bg-info">{{ $order->status_label }}</span></p>
                    <p><strong>Tạm tính:</strong> {{ number_format($order->subtotal, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }} VNĐ</p>
                    <hr>
                    <p><strong>Tổng cộng:</strong> <span class="text-danger fw-bold">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-4">Danh sách Sản phẩm</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>

@endsection