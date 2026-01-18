@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">

            {{-- HEADER: Tiêu đề Trang --}}
            <header class="text-center mb-5">
                <h1 class="h3 fw-bold text-dark mb-2">
                    <i class="bi bi-person-video me-2 text-primary"></i> Thử Kính Ảo 
                </h1>
                <p class="lead text-secondary">
                    Tải ảnh của bạn lên và chọn kiểu kính mong muốn để xem hiệu ứng.
                </p>
            </header>

            {{-- HIỂN THỊ LỖI --}}
            @if ($errors->any())
                <div class="alert alert-danger border-start border-4 border-danger shadow-sm mb-4" role="alert">
                    <h4 class="alert-heading h5"><i class="bi bi-exclamation-triangle-fill me-2"></i> Lỗi Thử Kính</h4>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- KẾT THÚC HIỂN THỊ LỖI --}}

            {{-- FORM CHÍNH --}}
            <form action="{{ route('glasses.try_on.process') }}" method="POST" enctype="multipart/form-data" class="card shadow p-4 p-md-5">
                @csrf

                
                
                {{-- 1. UPLOAD ẢNH --}}
                <div class="mb-4">
                    <label for="faceImage" class="form-label fw-semibold text-dark">
                        <i class="bi bi-image me-1"></i> 1. Tải lên ảnh khuôn mặt:
                    </label>
                    <input type="file" 
                           name="face_image" 
                           id="faceImage"
                           required 
                           class="form-control form-control-lg @error('face_image') is-invalid @enderror"
                           accept="image/jpeg,image/png">
                    <div class="form-text">Ảnh chính diện, rõ nét để có kết quả tốt nhất.</div>
                </div>

                {{-- 2. CHỌN KIỂU KÍNH --}}
                <div class="mb-4">
                    <label for="shapeSelect" class="form-label fw-semibold text-dark">
                        <i class="bi bi-sunglasses me-1"></i> 2. Chọn kiểu gọng kính:
                    </label>
                    <select name="shape" id="shapeSelect" class="form-select form-select-lg">
                        <option value="cateye">Cateye (Mắt Mèo)</option>
                        <option value="aviator">Aviator (Phi công)</option>
                        <option value="round">Round (Tròn)</option>
                        <option value="square">Square (Vuông)</option>
                        <option value="rectangle">Rectangle (Chữ nhật)</option> {{-- Thêm 1 option phổ biến --}}
                    </select>
                </div>

                {{-- 3. CHỌN MÀU KÍNH --}}
                <div class="mb-5">
                    <label for="colorSelect" class="form-label fw-semibold text-dark">
                        <i class="bi bi-palette-fill me-1"></i> 3. Chọn màu sắc:
                    </label>
                    <select name="color" id="colorSelect" class="form-select form-select-lg">
                        <option value="black">Đen (Cổ điển)</option>
                        <option value="brown">Nâu (Ấm áp)</option>
                        <option value="red">Đỏ (Nổi bật)</option>
                        <option value="blue">Xanh dương (Trẻ trung)</option>
                        <option value="silver">Bạc (Kim loại)</option> {{-- Thêm 1 option phổ biến --}}
                    </select>
                </div>

                {{-- NÚT HÀNH ĐỘNG --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        <i class="bi bi-check-circle-fill me-2"></i> Áp Dụng và Xem Kết Quả
                    </button>
                </div>
            </form>
            
            {{-- PHẦN KHÔNG CẦN THIẾT --}}
            {{-- Tôi đã loại bỏ thẻ form thứ hai bị lặp lại ở cuối trang --}}

        </div>
    </div>
</div>
@endsection