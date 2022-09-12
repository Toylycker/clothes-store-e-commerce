<nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-label="navbar">
    <div class="container-xxl">
        <a class="navbar-brand" href="{{ route('home') }}">@lang('app.app-name')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbars">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('outfits.home') }}">@lang('app.clothes')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('basket') }}">
                        <i class="bi bi-bag-heart-fill"></i> @lang('app.basket')
                        <span class="badge bg-secondary">{{count($basket)}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('categories') }}">
                        categories
                    </a>
                </li>
                @auth
                @endauth
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('outfit.create') }}">@lang('app.create')</a>
                    </li>
                @if(app()->isLocale('tm'))
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('language', 'en') }}">ENG</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('language', 'tm') }}">TKM</a>
                    </li>
                @endif
                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> @lang('app.login')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> @lang('app.register')
                        </a>
                    </li>
                @endguest
            </ul>
            @auth
                <li class="nav-item dropdown ms-auto">
                    <a href="#" class="nav-link dropdown-toggle fw-bold bg-white " data-bs-toggle="dropdown">{{Auth::user()->username}}</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        @if(Auth::user()->seller != null)
                            <a class="dropdown-item fw-bold" href="{{ route('seller.outfit.my_outfits') }}">@lang('app.my_outfits')</a>
                        @endif
                            <a class="nav-link fw-bold" href="{{ route('my_orders') }}">@lang('app.orders')</a>
                        @if(Auth::user()->seller != null)
                            <a class="nav-link fw-bold" href="{{ route('my_sales') }}">
                                @lang('app.my_sales') <span class="badge bg-secondary">{{$new_orders}}</span>
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="nav-link fw-bold" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="bi bi-box-arrow-right"></i> @lang('app.logout') <span class="text-warning">{{ auth()->user()->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                        </form>
                    </div>
                </li>
            @endauth

        </div>
    </div>
</nav>
