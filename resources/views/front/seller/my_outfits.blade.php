@extends('front.layouts.app')
@section('content')
<div class="container-fluid">
    @if($outfits!=null)
    <div class="container-xxl py-3">
        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
            <span class="d-block h4 mb-0 text-danger">@lang('app.my_outfits')</span>
            <span class="d-block"><i class="bi bi-chevron-right"></i></span>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
            @foreach($outfits as $outfit)
                <div class="col">
                    <div>    
                        <img src="{{ asset('img/temp/outfit.png') }}" alt="" class="img-fluid border rounded"> 
                    <div>
                            <a href="{{ route('outfit.show', [$outfit->id, $outfit->seller_id]) }}" class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
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
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection