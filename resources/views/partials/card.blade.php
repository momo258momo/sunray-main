@php
    $is_out_of_stock = isset($product['stock_quantity']) && $product['stock_quantity'] <= 0;
    $has_sale = isset($product['on_sale']) && $product['on_sale'] && !$is_out_of_stock;
    $sale_percent = isset($product['sale_percent']) ? $product['sale_percent'] : 0;
    $final_price = $product['price'];
    if($has_sale && $sale_percent > 0){
        $final_price = $product['price'] * (1 - $sale_percent / 100);
    }
@endphp

<article class="product-card-new {{ $is_out_of_stock ? 'is-out-of-stock' : '' }}">

    {{-- SALE BADGE --}}
    @if($has_sale && $sale_percent > 0)
        <span class="sale-badge-new">-{{ $sale_percent }}%</span>
    @endif

    {{-- IMAGE --}}
    <a href="{{ route('products.show', $product['slug']) }}"
       class="product-image-new">

        <img src="{{ asset($product['image_url']) }}"
             alt="{{ $product['name'] }}">

        @if($is_out_of_stock)
            <span class="out-of-stock-text">HẾT HÀNG</span>
        @endif
    </a>

    {{-- BODY --}}
    <div class="product-body-new">

        <h3 class="product-title-new">
            {{ $product['name'] }}
        </h3>

        <div class="product-bottom-new">

            {{-- PRICE --}}
            <div class="product-price-new">
                @if($has_sale && $sale_percent > 0)
                    <del>
                        {{ number_format($product['price'], 0, ',', '.') }} VNĐ
                    </del>
                    <span>
                        {{ number_format($final_price, 0, ',', '.') }} VNĐ
                    </span>
                @else
                    <span>
                        {{ number_format($product['price'], 0, ',', '.') }} VNĐ
                    </span>
                @endif
            </div>

            {{-- CART (ẨN KHI HẾT HÀNG) --}}
            @unless($is_out_of_stock)
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_slug" value="{{ $product['slug'] }}">
                    <button type="submit" class="cart-btn-new" title="Thêm vào giỏ hàng">
                        <svg viewBox="0 0 24 24" width="20" height="20"
                             stroke="currentColor" stroke-width="2"
                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                    </button>
                </form>
            @endunless

        </div>
    </div>
</article>
