<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
                <i class="bi bi-speedometer me-1"></i> @lang('app.dashboard')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.outfits.index')}}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.outfits')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.ages.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.ages')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.locations.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.locations')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.sellers.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.sellers')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tags.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.tags')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.users')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.options_values.index') }}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.optionvalues')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-speedometer me-1"></i> @lang('app.user-agents')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.visitors.index')}}">
                <i class="bi bi-speedometer me-1"></i> @lang('app.visitors')
            </a>
        </li>
    </ul>
</div>