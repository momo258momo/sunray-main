@extends('layouts.app')

@section('title', 'Kết quả gợi ý kính')

@section('content')
<div class="container py-4 py-md-5">

    {{-- TIÊU ĐỀ CHÍNH ĐÃ GIẢM KÍCH THƯỚC --}}
    <div class="text-center mb-5">
        <h2 class="text-secondary fw-normal">
            <i class="bi bi-eye-fill me-2"></i>Kết Quả Phân Tích Khuôn Mặt
        </h2>
        <p class="text-muted">Chúng tôi đã tìm ra dáng mặt của bạn và đưa ra những gợi ý phù hợp.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- PHẦN THÔNG TIN CHÍNH (Sử dụng Card và chia cột) --}}
            <div class="card shadow-sm mb-5">
                <div class="card-body p-4 p-md-4">
                    <div class="row">
                        {{-- DÁNG MẶT ĐƯỢC NHẬN DIỆN --}}
                        <div class="col-md-6 mb-4 mb-md-0 border-end">
                            <h4 class="card-title mb-3 fw-semibold text-dark">
                                <i class="bi bi-person me-2"></i>Dáng Mặt Của Bạn
                            </h4>
                            <p class="h3 mb-0 text-primary">
                                <span class="fw-bold">
                                    {{ $faceShapeVi[$faceShape] ?? ucfirst($faceShape) }}
                                </span>
                            </p>
                        </div>

                        {{-- GỌNG KÍNH PHÙ HỢP --}}
                        <div class="col-md-6">
                            <h4 class="card-title mb-3 fw-semibold text-dark">
                                <i class="bi bi-star me-2"></i>Gọng Kính Phù Hợp
                            </h4>
                            @if(!empty($glassShapes))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($glassShapes as $shape)
                                        <span class="badge bg-light text-dark border border-secondary p-2 fs-6">
                                            {{ $glassShapeVi[$shape] ?? ucfirst($shape) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted fst-italic pt-1">
                                    Chưa có dữ liệu gợi ý gọng kính phù hợp.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mb-5">

            {{-- SẢN PHẨM GỢI Ý --}}
            

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                @forelse ($products as $product)
                    <div class="col">
                        @include('partials.card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center" role="alert">
                            <i class="bi bi-info-circle me-2"></i> Hiện tại, chúng tôi chưa có sản phẩm phù hợp với dáng mặt **{{ $faceShapeVi[$faceShape] ?? ucfirst($faceShape) }}** trong kho.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- THỬ LẠI --}}
            <div class="mt-5 pt-3 text-center">
                <a href="{{ route('glasses.suggest.detect') }}"
                   class="btn btn-lg btn-outline-secondary px-5">
                    <i class="bi bi-arrow-clockwise me-2"></i>Thử lại với ảnh khác
                </a>
            </div>

        </div>
    </div>

</div>
@endsection