@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">

            {{-- HEADER: Tiêu đề và Mô tả --}}
            <header class="text-center mb-5">
                <h1 class="h3 fw-bold text-dark mb-2">
                    <i class="bi bi-camera-fill me-2 text-primary"></i> Phân Tích Dáng Mặt & Gợi Ý Kính
                </h1>
                <p class="lead text-secondary">
                    Tải lên ảnh khuôn mặt rõ nét của bạn để công cụ AI của chúng tôi phân tích chính xác và đưa ra gợi ý gọng kính hoàn hảo.
                </p>
            </header>

            {{-- HƯỚNG DẪN CHỤP ẢNH TỐI ƯU (ĐÃ KHÔI PHỤC THEO YÊU CẦU GỐC) --}}
            <div class="alert alert-info border-start border-4 border-info shadow-sm mb-4" role="alert">
                <h5 class="alert-heading fw-bold"><i class="bi bi-lightbulb-fill me-2"></i> Mẹo để có kết quả tốt nhất</h5>
                <ul class="mb-0">
                    <li>Ảnh cần là **khuôn mặt chính diện**, không nghiêng.</li>
                    <li>Khuôn mặt **không bị che khuất** (tóc, mũ, khăn...).</li>
                    <li>Đảm bảo **đủ ánh sáng** và không bị bóng râm.</li>
                    <li>Định dạng ảnh được chấp nhận: JPG, PNG.</li>
                </ul>
            </div>

            {{-- KHU VỰC CHÍNH --}}
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body p-4 p-md-5">

                    {{-- FORM TẢI ẢNH --}}
                    <form method="POST"
                          action="{{ route('glasses.suggest.detect.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="faceImage" class="form-label fw-semibold text-dark">
                                <i class="bi bi-image me-1"></i> Chọn tệp ảnh khuôn mặt:
                            </label>

                            {{-- Khu vực tải ảnh --}}
                            <div class="input-group input-group-lg">
                                <input type="file"
                                       name="face_image"
                                       id="faceImage"
                                       class="form-control @error('face_image') is-invalid @enderror"
                                       accept="image/jpeg,image/png"
                                       required>
                                <span class="input-group-text bg-white text-muted small border-start-0">Tối đa 5MB</span>
                            </div>
                        </div>

                        {{-- Hiển thị Lỗi (Error Messages) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-start border-4 border-danger mb-4" role="alert">
                                <h4 class="alert-heading h5"><i class="bi bi-x-octagon-fill me-2"></i> Lỗi Phân Tích Ảnh</h4>
                                @error('face_image')
                                    <p class="mb-1">{{ $message }}</p>
                                @enderror
                                @error('ai')
                                    <p class="mb-1">{{ $message }}</p>
                                @enderror
                                @if ($errors->missing(['face_image', 'ai']))
                                    <p class="mb-1">Đã xảy ra lỗi không xác định trong quá trình xử lý. Vui lòng thử lại.</p>
                                @endif
                            </div>
                        @endif

                        {{-- Nút Hành động --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-person-bounding-box me-2"></i> Bắt đầu Phân Tích
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            
            

        </div>
    </div>
</div>
@endsection