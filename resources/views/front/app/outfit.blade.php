<div>    
    <img src="{{ asset('img/temp/outfit.png') }}" alt="" class="img-fluid border rounded"> 
    <div>
        <a href="{{ route('outfit.show', [$outfit->id, $outfit->seller->id]) }}" class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
            {{ $outfit->name() }}
        </a>
            <p>@lang("app.Price"): {{$outfit->price}}</p>
            <p>@lang("app.description"): {{$outfit->description()}}</p>

            <a href="{{ route('add_to_basket', $outfit->id) }}">
                @if (!in_array($outfit->id, $basket))
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill"></i></button>
                    </div>
                @elseif(in_array($outfit->id, $basket))
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger"><i class="bi bi-dash-square"></i></button>
                    </div>
                @endif
            </a>
    </div>
</div>

    