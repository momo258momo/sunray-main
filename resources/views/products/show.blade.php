@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <div class="row g-5">

        {{-- LEFT: IMAGES --}}
        <div class="col-md-6">
            <div class="position-relative mb-3">
                <img id="mainProductImage"
                     src="{{ $images[0] ?? '' }}"
                     class="img-fluid rounded shadow-sm w-100"
                     style="cursor:pointer"
                     onclick="openModal(0)">

                {{-- SALE --}}
                @if($hasSale)
                    <span class="position-absolute top-0 end-0 bg-danger text-white px-3 py-2 fw-bold rounded-start">
                        -{{ $salePercent }}%
                    </span>
                @endif

                {{-- OUT OF STOCK --}}
                @if($stock === 0)
                    <span class="position-absolute top-0 start-0 bg-dark text-white px-3 py-2 fw-bold rounded-end">
                        HẾT HÀNG
                    </span>
                @endif
            </div>

            {{-- THUMBNAILS --}}
            @if(count($images) > 1)
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    @foreach($images as $i => $img)
                        <img src="{{ $img }}"
                             style="max-width:70px;cursor:pointer;border:1px solid #ddd;border-radius:6px;padding:4px;"
                             onclick="openModal({{ $i }})">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- RIGHT: INFO --}}
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product->name }}</h2>

            @if($product->frame_size)
                <div class="mb-2 text-muted">
                    Size: <strong>{{ $product->frame_size }} mm</strong>
                </div>
            @endif

            <div class="mb-3">
                <span class="badge bg-secondary">Đã bán {{ $sold }}</span>
            </div>

            {{-- RATING --}}
            @if($reviews->count())
                <div class="mb-3">
                    @for($i=1;$i<=5;$i++)
                        {{ $i <= round($avgRating) ? '⭐' : '☆' }}
                    @endfor
                    <small class="text-muted">
                        ({{ $avgRating }}/5 – {{ $reviews->count() }} đánh giá)
                    </small>
                </div>
            @endif

            {{-- PRICE --}}
            <div class="mb-3">
                @if($hasSale)
                    <del class="text-muted me-2">
                        {{ number_format($product->price,0,'.',',') }} VNĐ
                    </del>
                @endif
                <span class="fw-bold fs-4">
                    {{ number_format($finalPrice,0,'.',',') }} VNĐ
                </span>
            </div>

            {{-- ADD TO CART --}}
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_slug" value="{{ $product->slug }}">

                <p class="fw-bold {{ $stock ? 'text-success' : 'text-danger' }}">
                    {{ $stock ? "Còn: $stock" : 'Hết hàng' }}
                </p>

                <div class="d-flex gap-2">
                    <div class="input-group" style="width:120px;">
                        <button type="button" class="btn btn-outline-secondary" id="decrease" {{ $stock==0?'disabled':'' }}>-</button>
                        <input id="quantity" name="quantity" class="form-control text-center" value="1" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="increase" {{ $stock==0?'disabled':'' }}>+</button>
                    </div>

                    <button class="btn btn-primary px-4" {{ $stock==0?'disabled':'' }}>
                        Thêm vào giỏ
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABS --}}
    @include('partials.tabs')

    {{-- RELATED PRODUCTS --}}
    @if($relatedProducts->count())
        <h5 class="mt-5 mb-3">Sản phẩm tương tự</h5>
        <div class="row g-3">
            @foreach($relatedProducts as $item)
                <div class="col-md-3">
                    @include('partials.card', ['product' => $item])
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- IMAGE MODAL --}}
<div id="imageModal" class="modal-overlay">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <img class="modal-image" id="modalImage">
    <a class="prev-btn" onclick="changeImage(-1)">&#10094;</a>
    <a class="next-btn" onclick="changeImage(1)">&#10095;</a>
</div>
@endsection

{{-- JS DATA + FILE --}}
@push('scripts')
<script>
    window.productImages = @json($images);
    window.productStock  = {{ $stock }};
</script>
<script src="{{ asset('js/product-detail.js') }}"></script>
@endpush
