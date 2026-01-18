@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<div class="mb-5">
    @include('partials.hero')
</div>

{{-- ================= CORE VALUES / CAM KẾT (Đã chỉnh sửa 4 giá trị) ================= --}}
<section class="container pt-3 pb-5">
    <div class="row text-center">
        
        {{-- 1. Vận Chuyển --}}
        <div class="col-6 col-md-3 mb-4">
            <i class="bi bi-truck display-6 text-primary mb-3"></i>
            <h5 class="fw-bold">Miễn Phí Vận Chuyển</h5>
            <p class="text-muted small">Cho đơn hàng trên 500k toàn quốc</p>
        </div>
        
        {{-- 2. Bảo Hành --}}
        <div class="col-6 col-md-3 mb-4">
            <i class="bi bi-shield-lock display-6 text-primary mb-3"></i>
            <h5 class="fw-bold">Bảo Hành Dài Hạn</h5>
            <p class="text-muted small">Đổi trả 1-1 trong 30 ngày</p>
        </div>
        
        {{-- 3. Hỗ Trợ 24/7 --}}
        <div class="col-6 col-md-3 mb-4">
            <i class="bi bi-headset display-6 text-primary mb-3"></i>
            <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
            <p class="text-muted small">Giải đáp mọi thắc mắc qua Zalo, Hotline</p>
        </div>
        
        {{-- 4. Sản Phẩm Độc Quyền --}}
        <div class="col-6 col-md-3 mb-4">
            <i class="bi bi-gem display-6 text-primary mb-3"></i>
            <h5 class="fw-bold">Sản Phẩm Độc Quyền</h5>
            <p class="text-muted small">Các bộ sưu tập giới hạn, không trùng lặp</p>
        </div>
        
    </div>
    <hr class="my-3 opacity-25">
</section>

{{-- ================= FEATURED PRODUCTS (Sản phẩm nổi bật) - Đã cải tiến ================= --}}
<section class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2 text-dark">Sản phẩm nổi bật ✨</h2>
        <p class="text-secondary fs-6">
            Những mẫu kính được khách hàng lựa chọn nhiều nhất
        </p>
    </div>

    @if($featuredProducts->count())
        <div class="row g-4 g-md-4 g-lg-5">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.card')
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}?type=featured"
               class="btn btn-outline-primary fw-semibold px-5 py-2 rounded-pill">
                Khám phá thêm
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    @else
        <p class="text-center text-muted py-4">Chưa có sản phẩm nổi bật nào để hiển thị.</p>
    @endif

</section>

{{-- ================= BROWSE BY SHAPE (Tìm kiếm theo dáng kính) - ĐÃ CẬP NHẬT ================= --}}
<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2">Tìm kiếm theo dáng kính 📐</h2>
        <p class="text-secondary fs-6">
            Khám phá các dáng kính hot nhất và được yêu thích nhất
        </p>
    </div>

    <div class="row g-4">
        {{-- LƯU Ý: Thay thế 'path/to/...' bằng ảnh DÁNG KÍNH thực tế và đẹp mắt --}}
        
        {{-- 1. Gọng Vuông (Square) --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['shape' => 'square']) }}" class="d-block text-decoration-none">
                
                <h5 class="text-center text-dark fw-semibold">Gọng Vuông</h5>
            </a>
        </div>
        
        {{-- 2. Gọng Tròn (Round) --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['shape' => 'round']) }}" class="d-block text-decoration-none">
          
                <h5 class="text-center text-dark fw-semibold">Gọng Tròn</h5>
            </a>
        </div>
        
        {{-- 3. Gọng Mắt Mèo (Cat-eye) --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['shape' => 'cat-eye']) }}" class="d-block text-decoration-none">
               
                <h5 class="text-center text-dark fw-semibold">Gọng Mắt Mèo</h5>
            </a>
        </div>
        
        {{-- 4. Gọng Phi Công (Aviator) --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['shape' => 'aviator']) }}" class="d-block text-decoration-none">
              
                <h5 class="text-center text-dark fw-semibold">Gọng Phi Công</h5>
            </a>
        </div>
    </div>
</section>

{{-- ================= SALE BANNER ================= --}}
<div class="mb-5">
    @include('partials.sale')
</div>

{{-- ================= SALE PRODUCTS (Đang giảm giá) - Đã cải tiến ================= --}}
<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2 text-danger">Đang giảm giá 🔥</h2>
        <p class="text-secondary fs-6">
            Ưu đãi có thời hạn – số lượng giới hạn
        </p>
    </div>

    @if($productsOnSale->count())
        <div class="row g-4 g-md-4 g-lg-5">
            @foreach($productsOnSale as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.card')
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}?type=sale"
               class="btn btn-danger fw-semibold px-5 py-2 rounded-pill shadow-sm">
                Xem tất cả ưu đãi
                <i class="bi bi-tags-fill ms-2"></i>
            </a>
        </div>
    @else
        <p class="text-center text-muted py-4">Hiện chưa có sản phẩm giảm giá nào.</p>
    @endif
</section>

{{-- ================= TESTIMONIALS (Phản hồi khách hàng) - Bổ sung ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2">Phản Hồi Từ Khách Hàng ❤️</h2>
            <p class="text-secondary fs-6">
                Những đánh giá chân thực về chất lượng sản phẩm
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <blockquote class="blockquote text-center p-4 bg-white rounded-3 shadow-sm border-start border-5 border-primary">
                    <p class="mb-3 fst-italic">"Chất lượng kính vượt ngoài mong đợi, đeo rất nhẹ và thoải mái. Đặc biệt dịch vụ đo mắt tại cửa hàng rất chuyên nghiệp."</p>
                    <footer class="blockquote-footer mt-2">
                        Nguyễn Văn A, <cite title="Source Title">Hà Nội</cite>
                    </footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>

{{-- ================= CTA AI SUGGEST (Khôi phục trạng thái GỐC) ================= --}}
<section class="container py-5">
    <div class="p-5 rounded-4 text-center text-white"
         style="background: linear-gradient(135deg, #0d6efd, #084298);">
        <h4 class="fw-semibold mb-2">
            Chọn kính phù hợp khuôn mặt
        </h4>
        <p class="opacity-75 mb-4">
            Tải ảnh khuôn mặt – AI gợi ý mẫu kính phù hợp nhất
        </p>
        <a href="{{ route('glasses.suggest.index') }}"
           class="btn btn-light fw-semibold px-4">
            Trải nghiệm ngay
        </a>
    </div>
</section>

@endsection