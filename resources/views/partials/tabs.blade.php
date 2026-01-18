{{-- PRODUCT TABS --}}
<ul class="nav nav-tabs mt-5" role="tablist">
    <li class="nav-item">
        <button class="nav-link active"
                data-bs-toggle="tab"
                data-bs-target="#desc">
            Mô tả
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#spec">
            Thông số
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#reviews">
            Đánh giá ({{ $reviews->count() }})
        </button>
    </li>
</ul>

<div class="tab-content p-4 border border-top-0 bg-white shadow-sm">
    {{-- DESCRIPTION --}}
    <div class="tab-pane fade show active" id="desc">
        <div style="white-space: pre-line;">
            {{ $product->long_description }}
        </div>
    </div>

    {{-- SPEC --}}
    <div class="tab-pane fade" id="spec">
        <ul class="mb-0">
            @if($product->frame_size)
                <li>Size: {{ $product->frame_size }} mm</li>
            @endif
            <li>Chất liệu: {{ $product->material }}</li>
            <li>Màu sắc: {{ $product->color }}</li>
            <li>Kiểu dáng: {{ $product->shape }}</li>
        </ul>
    </div>

    {{-- REVIEWS --}}
    <div class="tab-pane fade" id="reviews">
        @forelse($reviews as $review)
            <div class="border rounded p-3 mb-3 shadow-sm">
                <div class="d-flex justify-content-between mb-1">
                    <strong>
    {{ trim($review->user->first_name . ' ' . $review->user->last_name) ?? 'Người dùng ẩn danh' }}
</strong>

                    <small class="text-muted">
                        {{ $review->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>

                <div class="mb-2">
                    @for($i=1;$i<=5;$i++)
                        {{ $i <= $review->rating ? '⭐' : '☆' }}
                    @endfor
                </div>

                <p class="mb-0">
                    {{ $review->comment ?? 'Không có nhận xét' }}
                </p>
            </div>
        @empty
            <p class="text-muted">Chưa có đánh giá nào</p>
        @endforelse
    </div>
</div>
