@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Tăng kích thước cột để ảnh có nhiều không gian hơn, ví dụ: col-lg-10 col-xl-8 --}}
        <div class="col-lg-10 col-xl-8"> 

            {{-- HEADER: Tiêu đề Trang --}}
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
                {{-- Giữ padding lớn để khung ảnh đẹp hơn --}}
                <div class="card-body p-4 p-md-5 text-center"> 
                    
                    @if(isset($result_image))
                        <h4 class="fw-semibold mb-3 text-primary">Hình ảnh kết quả</h4>
                        <div class="img-container">
                            {{-- THAY ĐỔI: Tăng kích thước ảnh bằng cách loại bỏ 'max-width: 100%' trên style và phụ thuộc vào col-lg-10/col-xl-8 bên trên --}}
                            <img src="{{ $result_image }}" 
                                 alt="Kết quả đeo kính ảo" 
                                 class="img-fluid rounded shadow-lg border border-secondary-subtle" 
                                 style="width: 100%; height: auto;"> {{-- Đảm bảo ảnh chiếm hết chiều rộng của container cha --}}
                        </div>
                    @else
                        {{-- THÔNG BÁO LỖI/CẢNH BÁO --}}
                        <div class="alert alert-warning border-start border-4 border-warning" role="alert">
                            <h4 class="alert-heading h5"><i class="bi bi-exclamation-triangle-fill me-2"></i> Không thể tạo ảnh kết quả!</h4>
                            <p class="mb-0">Có vẻ như quá trình xử lý ảnh thất bại hoặc Flask API chưa trả về ảnh. Vui lòng thử lại với một ảnh khác.</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- NÚT HÀNH ĐỘNG --}}
            <div class="text-center mt-4">
                <a href="{{ route('glasses.try_on.form') }}" class="btn btn-primary btn-lg px-5 fw-bold">
                    <i class="bi bi-arrow-clockwise me-2"></i> Thử lại với gọng kính khác
                </a>
            </div>
            
            {{-- XÓA PHẦN: Quay về trang chủ (Đã được xóa theo yêu cầu) --}}
            {{--
            <div class="text-center mt-3">
                <a href="/" class="btn btn-sm btn-link text-secondary">
                    <i class="bi bi-house-door"></i> Quay về Trang chủ
                </a>
            </div>
            --}}

        </div>
    </div>
</div>
@endsection