@foreach($order->orderItems as $item)
    @if(!$item->review)
        <div class="card card-body bg-light mb-3">
            <h6 class="text-primary">⭐ {{ $item->product->name }}</h6>

            <input type="hidden" name="items[{{ $item->id }}][order_item_id]" value="{{ $item->id }}">
            <input type="hidden" name="items[{{ $item->id }}][product_id]" value="{{ $item->product_id }}">

            <div class="mb-2">
                @for($i = 5; $i >= 1; $i--)
                    <label class="me-3 text-warning">
                        <input type="radio"
                               name="items[{{ $item->id }}][rating]"
                               value="{{ $i }}">
                        {{ str_repeat('★', $i) }}
                    </label>
                @endfor
            </div>

            <textarea class="form-control"
                      name="items[{{ $item->id }}][comment]"
                      rows="2"
                      placeholder="Bình luận (không bắt buộc)"></textarea>
        </div>
    @endif
@endforeach
