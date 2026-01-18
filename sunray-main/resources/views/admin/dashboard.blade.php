@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

<h2 class="mb-4">Tổng quan Hệ thống</h2>

{{-- HÀNG 1: THỐNG KÊ CHUNG --}}
<div class="row g-4 mb-4">
    {{-- Card 1: Người dùng --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Người dùng</h6>
                    {{-- SỬA LỖI: Gọi trực tiếp Model để tránh Undefined Variable --}}
                    <h3>{{ \App\Models\User::count() }}</h3> 
                </div>
                <div class="text-primary" style="font-size: 40px;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Sản phẩm --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Sản phẩm</h6>
                    {{-- Gọi trực tiếp Model --}}
                    <h3>{{ \App\Models\Product::count() }}</h3> 
                </div>
                <div class="text-success" style="font-size: 40px;">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 3: Đơn hàng TỔNG --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Tổng đơn hàng</h6>
                    {{-- Gọi trực tiếp Model --}}
                    <h3>{{ \App\Models\Order::count() }}</h3>
                </div>
                <div class="text-info" style="font-size: 40px;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- HÀNG 2: THỐNG KÊ HÔM NAY VÀ ĐƠN HÀNG CẦN XỬ LÝ (Sử dụng cú pháp @if(isset) để an toàn hơn) --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Đơn hàng hôm nay</h6>
                    {{-- Dùng isset để tránh lỗi nếu Controller không truyền biến --}}
                    <h3>{{ $ordersToday ?? \App\Models\Order::whereDate('created_at', \Carbon\Carbon::today())->count() }}</h3>
                </div>
                <div class="text-warning" style="font-size: 40px;">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Doanh thu hôm nay (Đã giao)</h6>
                    {{-- Dùng isset và toán tử null coalescing để tránh lỗi --}}
                    @php
                        $revenue = $revenueToday ?? \App\Models\Order::whereDate('created_at', \Carbon\Carbon::today())->where('status', 3)->sum('total');
                    @endphp
                    <h3 class="text-success">{{ number_format($revenue, 0, ',', '.') }} VNĐ</h3>
                </div>
                <div class="text-success" style="font-size: 40px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Đơn hàng chờ xử lý</h6>
                    {{-- Dùng isset --}}
                    <h3>{{ $pendingOrders ?? \App\Models\Order::where('status', 1)->count() }}</h3>
                </div>
                <div class="text-danger" style="font-size: 40px;">
                    <i class="fa-solid fa-truck-loading"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- HÀNG 3: BIỂU ĐỒ & ĐƠN HÀNG MỚI NHẤT (Vẫn cần biến từ Controller) --}}
<div class="row g-4">
    
    {{-- PHẦN 1: BIỂU ĐỒ DOANH THU 7 NGÀY --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-bold border-bottom">
                <i class="fa-solid fa-chart-line me-2 text-primary"></i> Doanh thu 7 ngày gần nhất (VNĐ)
            </div>
            <div class="card-body">
                {{-- Biểu đồ rất cần $chartLabels và $chartData từ Controller --}}
                <canvas id="revenueChart" style="max-height: 300px;"></canvas> 
            </div>
        </div>
    </div>

    {{-- PHẦN 2: ĐƠN HÀNG MỚI NHẤT --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-bold border-bottom">
                <i class="fa-solid fa-receipt me-2 text-info"></i> 5 Đơn hàng mới nhất
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="py-2">Mã ĐH</th>
                                <th class="py-2">Khách hàng</th>
                                <th class="py-2">Tổng tiền</th>
                                <th class="py-2">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($latestOrders))
                                @foreach ($latestOrders as $order)
                                <tr>
                                    <td><a href="#" class="text-primary fw-semibold">#{{ $order->id }}</a></td>
                                    <td>{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = [1 => 'warning', 2 => 'info', 3 => 'success', 4 => 'danger', 5 => 'secondary'][$order->status] ?? 'light';
                                            $statusText = [1 => 'Chờ XL', 2 => 'Đã XN', 3 => 'Đã giao', 4 => 'Hủy', 5 => 'Hoàn'][$order->status] ?? 'Khác';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                @if ($latestOrders->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Không có đơn hàng nào gần đây.</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-danger">Lỗi: Không thể tải danh sách đơn hàng mới nhất (Undefined variable $latestOrders).</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center border-top">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Xem tất cả đơn hàng</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra xem dữ liệu biểu đồ có tồn tại không
        if (typeof {!! $chartLabels ?? 'null' !!} !== 'undefined' && {!! $chartLabels ?? 'null' !!} !== null) {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $chartLabels ?? '[]' !!}, // Dữ liệu ngày tháng từ Controller
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: {!! $chartData ?? '[]' !!}, // Dữ liệu doanh thu từ Controller
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    if (parseInt(value) >= 1000) {
                                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + 'k';
                                    } else {
                                        return value;
                                    }
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

@endsection