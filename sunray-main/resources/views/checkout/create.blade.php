@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
<div class="container mt-5 pb-5">
    <h4 class="mb-2">Thanh Toán</h4>

    <div class="row">
        <!-- FORM THÔNG TIN KHÁCH HÀNG -->
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <h5 class="mt-4">Thông Tin Khách Hàng</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               value="{{ auth()->user()->first_name }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               value="{{ auth()->user()->last_name }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               value="{{ auth()->user()->email }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" 
                               name="phone_number" value="{{ old('phone_number') }}">
                        @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa Chỉ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" 
                           name="address" value="{{ old('address') }}">
                    @error('address')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú Đơn Hàng</label>
                    <textarea name="order_notes" rows="3" 
                              class="form-control">{{ old('order_notes') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary px-3 py-2 mb-4">
                    Đặt Hàng
                </button>
            </form>
        </div>

        <!-- TỔNG GIỎ HÀNG -->
        <div class="col-lg-5 mt-lg-3">
            <table class="table border mt-lg-5">
                <thead>
                    <tr>
                        <td colspan="2">
                            <h4 class="mb-0">Tổng Giỏ Hàng</h4>
                        </td>
                    </tr>
                </thead>

                <tbody class="fw-bold">
                    <tr>
                        <td>Tạm Tính</td>
                        <td>{{ number_format($subTotal, 0, ',', '.') }} VNĐ</td>
                    </tr>

                    <tr>
                        <td>Phí Ship</td>
                        <td>20.000 VNĐ</td>
                    </tr>

                    <tr>
                        <td>Tổng Cộng</td>
                        <td>
                            {{ number_format($subTotal + 20000, 0, ',', '.') }} VNĐ
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
