<div>
    <img src="{{ asset('img/temp/outfit.png') }}" alt="" class="img-fluid border rounded">
    <div>
        <a href="{{ route('outfit.show', [$outfit->id, $outfit->seller->id]) }}"
            class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
            {{ $outfit->name() }}
        </a>
        <div class="container overflow-auto" style="height:100px;">
            <p>@lang('app.Price'): {{ $outfit->price }}   @lang('app.money')</p>
            <p>@lang('app.description'): {{ $outfit->description() }}</p>
        </div>
    </div>
</div>
