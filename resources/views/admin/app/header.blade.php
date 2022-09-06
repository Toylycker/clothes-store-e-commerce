<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">@lang('app.app-name')</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            @auth
                <a class="nav-link px-3" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i class="bi bi-box-arrow-right"></i> @lang('app.logout') <span class="text-warning">{{ auth()->user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    @honeypot
                </form>
            @endauth
        </div>
    </div>
</header>