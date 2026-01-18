@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- HEADER --}}
            <header class="text-center mb-5">
                <h1 class="h3 fw-bold text-dark mb-2">
                    <i class="bi bi-check-circle-fill me-2 text-success"></i> Kết Quả Thử Kính Ảo
                </h1>
                <p class="lead text-secondary">
                    Đây là ảnh khuôn mặt của bạn sau khi áp dụng gọng kính đã chọn.
                </p>
            </header>

            {{-- KHUNG HIỂN THỊ KẾT QUẢ --}}
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body p-4 p-md-5 text-center">

                    @if(isset($result_image))
                        <h4 class="fw-semibold mb-3 text-primary">Hình ảnh kết quả</h4>
                        <div class="img-container mb-4">
                            <img src="{{ $result_image }}" 
                                 alt="Kết quả đeo kính ảo" 
                                 class="img-fluid rounded shadow-lg border border-secondary-subtle" 
                                 style="width: 100%; height: auto;">
                        </div>
                    @else
                        <div class="alert alert-warning border-start border-4 border-warning" role="alert">
                            <h4 class="alert-heading h5">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Không thể tạo ảnh kết quả!
                            </h4>
                            <p class="mb-0">
                                Có vẻ như quá trình xử lý ảnh thất bại hoặc Flask API chưa trả về ảnh. Vui lòng thử lại với một ảnh khác.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- NÚT THỬ KÍNH KHÁC --}}
            <div class="text-center mt-4 mb-5">
                <a href="{{ route('glasses.try_on.form') }}" class="btn btn-primary btn-lg px-5 fw-bold">
                    <i class="bi bi-arrow-clockwise me-2"></i> Thử lại với gọng kính khác
                </a>
            </div>

            {{-- SẢN PHẨM TƯƠNG TỰ --}}
            @if(isset($similar_products) && $similar_products->count() > 0)
                <h3 class="fw-bold text-dark mb-4">Sản phẩm tương tự</h3>
                <div class="row g-4">
                    @foreach($similar_products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            {{-- Gọi partial card.blade.php --}}
                            @include('partials.card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
