<header class="sticky-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg container">
        <div class="container-fluid px-3 px-md-2">

            <!-- MOBILE TOGGLE -->
            <button class="navbar-toggler border-0 p-0" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbar-primary"
                    aria-controls="navbar-primary"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <svg viewBox="0 0 24 24" width="24" height="24"
                     stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- LOGO -->
            <a class="navbar-brand p-0 d-flex align-items-center ms-4 ms-lg-0"
               href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Sun Ray" style="width:38px">
                <span class="fw-bold fs-4 ms-2" style="letter-spacing: 0.10rem;">
                    <span>EYE</span>ON
                </span>
            </a>

            <!-- MENU -->
            <div class="collapse navbar-collapse" id="navbar-primary">
                <ul class="navbar-nav ms-lg-auto text-center align-items-lg-center">

                    <li class="nav-item me-lg-2">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>

                    <li class="nav-item me-lg-2">
                        <a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a>
                    </li>

                    {{-- ✅ FIXED ROUTE --}}
                    <li class="nav-item me-lg-2">
                        <a class="nav-link"
                           href="{{ route('glasses.suggest.index') }}">
                            Gợi ý kính
                        </a>
                    </li>

                    {{-- ================= ACCOUNT ================= --}}
                    <li class="nav-item dropdown me-lg-3 d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           style="cursor:pointer;">

                            <svg viewBox="0 0 24 24" width="22" height="22"
                                 stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 class="text-brown">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                            @auth
                                <li>
                                    <span class="dropdown-item text-muted small">
                                        {{ auth()->user()->fullName }}
                                    </span>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        📦 Đơn hàng của tôi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('account.show') }}">
                                        ⚙️ Tài khoản của tôi
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="dropdown-item text-danger">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            @endauth

                            @guest
                                <li>
                                    <a class="dropdown-item" href="{{ route('login.create') }}">
                                        Đăng nhập
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register.create') }}">
                                        Đăng ký
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </li>

                    {{-- ================= CART ================= --}}
                    <li class="nav-item d-none d-lg-inline-block">
                        <a href="{{ route('cart.index') }}"
                           class="mt-3 mt-lg-1 d-inline-block position-relative text-black">

                            <span class="position-absolute start-100 translate-middle badge rounded-pill bg-brown text-white badge-cart">
                                {{ (new App\Services\CartService())->getCartItemsCount() }}
                            </span>

                            <svg viewBox="0 0 24 24" width="20" height="20"
                                 stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
