<div class="filter-bar-wrapper mt-4 w-100">
    <form method="GET"
          action="{{ route('products.index') }}"
          class="d-flex flex-wrap align-items-end gap-3 p-3 bg-light shadow-sm">

        {{-- SEARCH --}}
        <div class="flex-grow-1" style="min-width:200px">
            <label class="form-label small">Tìm sản phẩm</label>
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Nhập tên sản phẩm..."
                   value="{{ request('search') }}">
        </div>

        {{-- CATEGORY --}}
        <div style="min-width:160px">
            <label class="form-label small">Danh mục</label>
            <select name="category" class="form-select">
                <option value="">Tất cả</option>
                <option value="glasses" {{ request('category') == 'glasses' ? 'selected' : '' }}>
                    Kính mắt
                </option>
            </select>
        </div>

        {{-- SHAPE --}}
        <div style="min-width:180px">
            <label class="form-label small">Dáng kính</label>
            <select name="shape" class="form-select">
                <option value="">Tất cả</option>
                <option value="square" {{ request('shape') == 'square' ? 'selected' : '' }}>Gọng vuông</option>
                <option value="rectangle" {{ request('shape') == 'rectangle' ? 'selected' : '' }}>Gọng chữ nhật</option>
                <option value="round" {{ request('shape') == 'round' ? 'selected' : '' }}>Gọng tròn</option>
                <option value="oval" {{ request('shape') == 'oval' ? 'selected' : '' }}>Gọng oval</option>
                <option value="cat-eye" {{ request('shape') == 'cat-eye' ? 'selected' : '' }}>Gọng mắt mèo</option>
                <option value="aviator" {{ request('shape') == 'aviator' ? 'selected' : '' }}>Gọng phi công</option>
                <option value="polygon" {{ request('shape') == 'polygon' ? 'selected' : '' }}>Gọng đa giác</option>
                <option value="semi-rimless" {{ request('shape') == 'semi-rimless' ? 'selected' : '' }}>Gọng nửa viền</option>
            </select>
        </div>

        {{-- SORT --}}
        <div style="min-width:160px">
            <label class="form-label small">Sắp xếp giá</label>
            <select name="sort" class="form-select">
                <option value="">Mặc định</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                    Giá thấp → cao
                </option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                    Giá cao → thấp
                </option>
            </select>
        </div>

        {{-- BUTTON --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4" style="height:38px">
                LỌC
            </button>

            {{-- RESET FILTER --}}
            <a href="{{ route('products.index') }}"
               class="btn btn-outline-secondary px-4"
               style="height:38px; line-height:24px">
                XÓA LỌC
            </a>
        </div>
    </form>
</div>
