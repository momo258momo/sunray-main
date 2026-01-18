{{-- admin_sidebar.blade.php --}}
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Admin Panel</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action bg-light">Sản phẩm</a>
        <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action bg-light">Đơn hàng</a>
        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-light">Người dùng</a>
        {{-- Thêm link khác nếu cần --}}
    </div>
</div>
