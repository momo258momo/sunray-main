@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')

<div class="container mt-5 pb-5">

    

    <header class="row align-items-center mb-4">
        <div class="col-6">
            <h4 class="mb-0">Giỏ Hàng</h4>
        </div>
        <div class="col-6 d-flex justify-content-end">
            @if(isset($cartItems) && count($cartItems) > 0)
                <form action="{{ route('cart.destroy.all') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-muted small btn btn-sm">
                        Xóa Giỏ Hàng
                    </button>
                </form>
            @endif
        </div>
    </header>

    @if(isset($cartItems) && count($cartItems) > 0)

    <div class="table-responsive">
        <table class="table table-bordered align-middle" style="min-width: 50rem;">
            <thead class="small">
                <tr>
                    <th></th>
                    <th>Sản Phẩm</th>
                    <th class="text-center">Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th class="text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody>

                @foreach($cartItems as $cartItem)

                <tr>
                    <td style="width: 7rem;">
                        <img
                            src="{{ asset($cartItem['image_url'] ?? 'images/default.jpg') }}"
                            alt="{{ $cartItem['name'] }}"
                            class="rounded w-100"
                        >
                    </td>

                    <td>{{ $cartItem['name'] }}</td>

                    {{-- SỐ LƯỢNG +/- --}}
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">

                            {{-- GIẢM --}}
                            <form action="{{ route('cart.update', $cartItem['product_id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="quantity" value="{{ $cartItem['quantity'] - 1 }}">
                                <button
                                    class="btn btn-sm border-0 bg-transparent fs-5 px-2"
                                    {{ $cartItem['quantity'] <= 0 ? 'disabled' : '' }}
                                >−</button>
                            </form>

                            <span class="fw-bold">
                                {{ $cartItem['quantity'] }}
                            </span>

                            {{-- TĂNG --}}
                            <form action="{{ route('cart.update', $cartItem['product_id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="quantity" value="{{ $cartItem['quantity'] + 1 }}">
                                <button
                                    class="btn btn-sm border-0 bg-transparent fs-5 px-2"
                                    {{ $cartItem['quantity'] >= $cartItem['stock_quantity'] ? 'disabled' : '' }}
                                >+</button>
                            </form>

                        </div>

                        
                    </td>

                    <td>
                        {{ number_format($cartItem['price'], 0, '.', ',') }} VNĐ
                    </td>

                    <td>
                        {{ number_format($cartItem['price'] * $cartItem['quantity'], 0, '.', ',') }} VNĐ
                    </td>

                    {{-- XÓA --}}
                    <td class="text-center">
                        <form action="{{ route('cart.destroy', $cartItem['product_id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">&times;</button>
                        </form>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </div>

    {{-- TỔNG --}}
    <div class="row justify-content-end">
        <div class="col-md-6">
            @php $shippingFee = 20000; @endphp
            <table class="table border">
                <tbody class="fw-bold">
                    <tr>
                        <td>Tạm Tính</td>
                        <td>{{ number_format($subTotal, 0, '.', ',') }} VNĐ</td>
                    </tr>
                    <tr>
                        <td>Phí Ship</td>
                        <td>{{ number_format($shippingFee, 0, '.', ',') }} VNĐ</td>
                    </tr>
                    <tr>
                        <td>Tổng Cộng</td>
                        <td>{{ number_format($subTotal + $shippingFee, 0, '.', ',') }} VNĐ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        @auth
            <a href="{{ route('checkout.create') }}" class="btn btn-primary">
                Thanh Toán
            </a>
        @endauth

        @guest
            <p class="text-muted">
                Vui lòng
                <a href="{{ route('register.create') }}">Đăng Ký</a> /
                <a href="{{ route('login.create') }}">Đăng Nhập</a>
                để thanh toán
            </p>
        @endguest
    </div>

    @else
        <p class="text-muted">
            Giỏ hàng trống
            <a href="{{ route('products.index') }}">Quay lại cửa hàng</a>
        </p>
    @endif

</div>

@endsection
