@extends('layouts.app')

@section('title', 'Sản Phẩm')

@section('content')

<section class="container my-5">

    {{-- FILTER (FULL WIDTH) --}}
    <div class="row mb-4">
        <div class="col-12">
            @include('partials.filters')
        </div>
    </div>

    {{-- DANH SÁCH SẢN PHẨM --}}
    <div class="row">

        @if ($products->count())

            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    @include('partials.card')
                </div>
            @endforeach

            <div class="col-12 d-flex justify-content-end mt-3">
                {{ $products->links() }}
            </div>

        @else
            <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
        @endif

    </div>

</section>
@endsection