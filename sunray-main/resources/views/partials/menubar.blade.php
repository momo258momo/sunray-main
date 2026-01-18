{{-- menubar for small and medium screens --}}

{{-- search --}}
<a href="{{ route('products.index') }}" class="d-inline-block me-2">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
    class="text-brown"
        fill="none" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
</a>

{{-- user dropdown --}}
<div class="dropdown d-inline-block me-2">
    <a class="btn p-0" href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        class="text-brown"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
    </a>
    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
        
        @auth
            <li><a class="dropdown-item" href="{{ route('account.show') }}">{{ auth()->user()->first_name }}</a></li>
            <li>
                <form class="dropdown-item" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item p-0">Logout</button>
            </form>
        </li>
        @endauth

        @guest
            <li><a class="dropdown-item" href="{{ route('register.create') }}">Regsiter</a></li>
            <li><a class="dropdown-item" href="{{ route('login.create') }}">Login</a></li>
        @endguest
    </ul>
</div>

{{-- cart --}}
<a href="{{ route('cart.index') }}" class="d-inline-block text-muted position-relative me-2">

    <span
        class="position-absolute start-100 translate-middle badge rounded-pill bg-brown text-white fw-semibold"
        style="top: 4px;">
        
        {{ (new App\Services\CartService())->getCartItemsCount() }}

    </span>

    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
    class="text-brown"
        fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
        <line x1="3" y1="6" x2="21" y2="6">
        </line>
        <path d="M16 10a4 4 0 0 1-8 0"></path>
    </svg>
</a>
