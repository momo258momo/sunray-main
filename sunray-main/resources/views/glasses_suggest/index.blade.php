@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- Phần Tiêu đề Chính (Hero Section) --}}
            <header class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">
                    <i class="bi bi-eyeglasses me-2"></i> Khám phá Gọng Kính Hoàn Hảo
                </h1>
                <p class="lead text-secondary mt-3">
                    Xác định dáng mặt chính xác bằng AI và trải nghiệm thử kính ảo ngay tại nhà.
                </p>
                <hr class="w-50 mx-auto my-4">
            </header>

            {{-- Khu vực chức năng chính - Dùng Card để phân chia rõ ràng --}}
            <div class="row g-4">

                {{-- Card 1: Xác định dáng mặt --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-lg border-primary">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-camera-fill text-primary display-4 mb-3"></i>
                            <h2 class="card-title h4 fw-bold mb-3">1. Xác Định Dáng Mặt</h2>
                            <p class="card-text text-muted mb-4">
                                Tải ảnh khuôn mặt chính diện rõ nét để AI phân tích và đưa ra gợi ý gọng kính phù hợp nhất với dáng mặt của bạn.
                            </p>
                            <a href="{{ route('glasses.suggest.detect') }}"
                               class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-magic me-2"></i> Bắt Đầu Phân Tích
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Thử kính ảo --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-lg border-success">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-person-video2 text-success display-4 mb-3"></i>
                            <h2 class="card-title h4 fw-bold mb-3">2. Thử Kính Ảo </h2>
                            <p class="card-text text-muted mb-4">
                                Trải nghiệm ngay các mẫu gọng kính trong bộ sưu tập lên khuôn mặt của bạn trước khi quyết định mua.
                            </p>
                            <a href="{{ route('glasses.try_on.form') }}"
                               class="btn btn-success btn-lg w-100">
                                <i class="bi bi-glasses me-2"></i> Thử Kính Ngay
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Lưu ý nhỏ (Optional) --}}
            <div class="text-center mt-5">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i> Để có kết quả tốt nhất, hãy đảm bảo khuôn mặt không bị che khuất và ánh sáng đủ.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection