@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="mb-4 text-center text-warning">
                📝 Yêu cầu trả hàng
            </h2>

            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('returns.store', $order) }}"
                  class="bg-white p-4 shadow rounded">
                @csrf

                @php
                    $returnReasons = [
                        'Sản phẩm bị lỗi/hỏng',
                        'Sai kích thước hoặc màu sắc',
                        'Không đúng mô tả',
                        'Thiếu sản phẩm',
                        'Không còn nhu cầu',
                    ];
                @endphp

                @foreach($order->orderItems as $item)
                    <div class="card mb-4 border-warning">
                        <div class="card-header bg-light">
                            <strong>{{ $item->product->name }}</strong>
                        </div>

                        <div class="card-body">

                            {{-- CHECKBOX CHỌN TRẢ --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input return-checkbox"
                                       type="checkbox"
                                       name="selected_items[]"
                                       value="{{ $item->id }}"
                                       data-target="#fields-{{ $item->id }}"
                                       id="check-{{ $item->id }}">

                                <label class="form-check-label text-danger fw-bold"
                                       for="check-{{ $item->id }}">
                                    Trả sản phẩm này
                                </label>
                            </div>

                            {{-- FIELDS --}}
                            <div id="fields-{{ $item->id }}" class="return-fields d-none">

                                {{-- LÝ DO --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Lý do trả hàng
                                    </label>

                                    @foreach($returnReasons as $index => $reason)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="items[{{ $item->id }}][reason_code]"
                                                   value="{{ $reason }}"
                                                   id="reason-{{ $item->id }}-{{ $index }}">

                                            <label class="form-check-label"
                                                   for="reason-{{ $item->id }}-{{ $index }}">
                                                {{ $reason }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- MÔ TẢ --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Mô tả chi tiết
                                    </label>
                                    <textarea class="form-control"
                                              name="items[{{ $item->id }}][reason_detail]"
                                              rows="3"
                                              placeholder="Mô tả chi tiết (không bắt buộc)"></textarea>
                                </div>

                                {{-- HÌNH ẢNH --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Ảnh minh chứng
                                    </label>
                                    <input type="file"
                                           class="form-control"
                                           name="items[{{ $item->id }}][image]"
                                           accept="image/*">
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-warning px-4">
                        Gửi yêu cầu trả hàng
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
document.querySelectorAll('.return-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
        const target = document.querySelector(this.dataset.target);
        if (this.checked) {
            target.classList.remove('d-none');
        } else {
            target.classList.add('d-none');
        }
    });
});
</script>
@endsection
