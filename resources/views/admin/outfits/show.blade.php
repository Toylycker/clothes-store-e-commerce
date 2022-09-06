@extends('front.layouts.app')
@section('title') {{ $outfitseller->outfit->name() }} @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
            <div class="h4 text-danger">{{ $outfitseller->outfit->name() }}</div>
            @auth
            @if (Auth::user()->seller != null and Auth::user()->seller->id == $outfitseller->seller->id or Auth::user()->role=='admin')
                <div>
                    <a href="{{ route('admin.outfit.edit', [$outfitseller->outfit->id, $outfitseller->seller_id]) }}" class="btn btn-success btn-sm text-decoration-none">
                        <i class="bi bi-pencil-fill"></i> @lang('app.edit')
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash-fill"></i> @lang('app.delete')
                    </button>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @lang('app.delete-question', ['name' => $outfitseller->outfit->name()])
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.outfit.delete', [$outfitseller->outfit->id, $outfitseller->seller_id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('app.cancel')</button>
                                        <button type="submit" class="btn btn-secondary">@lang('app.delete')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endauth
        </div>

        
        <div class="row g-3">
            <div class="col-sm-6 col-lg-4">
                <div class="position-relative d-flex justify-content-center align-items-center">
                    <img src="{{ $outfitseller->outfit->image() }}" alt="" class="img-fluid border rounded">
                </div>
            </div>




            <div class="col">
                <div class="d-block h2 fw-bold mb-3">
                    {{ $outfitseller->outfit->name() }}
                    <p>@lang('app.Price') {{ $outfitseller->price}} </p>
                </div>
                <p>@lang('app.description'):{{ $outfitseller->description() }}</p>
                <p>@lang('app.year_or_size'):{{ $outfitseller->outfit->age->name() }}</p>
                <a href="#" class="d-block h5 fw-bold link-secondary mb-3">
                    @lang('app.Seller'): {{ $outfitseller->seller->name }}
                </a>
                <p>@lang('app.Company'):{{ $outfitseller->seller->company_name }}</p>
                <p>@lang('app.Phone'): {{ $outfitseller->seller->phone }}</p>
                <p>@lang('app.Shop Place'):{{ $outfitseller->seller->location->name() }}</p>
                @foreach($outfitseller->outfit->tags as $tag)
                    <a href="{{route('results', ['t'=>$tag->id])}}" class="d-block h5 fw-bold link-secondary mb-3">
                        <span>{{ $tag->name()}}</span>
                    </a>
                @endforeach
                @foreach($outfitseller->outfit->values as $value)
                    <a href="#" class="d-block h5 fw-bold link-secondary mb-3">
                        <span>{{ $value->name_en}}</span>
                    </a>
                @endforeach

                <div class="h5 fw-bold mb-3">
                    {{-- @if($outfitseller->isDiscount())
                        <span class="text-secondary"><s>{{ number_format($outfitseller->price, 2, ".", " ") }}</s></span>
                        <span class="text-danger">{{ number_format($outfitseller->price(), 2, ".", " ") }} <small>TMT</small></span>
                    @else
                        <span class="text-primary">{{ number_format($outfitseller->price, 2, ".", " ") }} <small>TMT</small></span>
                    @endif --}}
                    @if($outfitseller->credit)
                        <i class="bi bi-patch-check-fill text-info"></i>
                    @endif
                </div>
                <div class="d-flex align-items-center fw-bold mb-3">
                    <div class="me-4">
                        <i class="bi bi-basket-fill text-black-50"></i> {{ $outfitseller->sold }}
                    </div>
                    <div class="me-4">
                        <i class="bi bi-binoculars-fill text-black-50"></i> {{ $outfitseller->outfit->viewed }}
                    </div>
                    <a href="#" class="btn btn-danger btn-sm text-decoration-none">
                        <i class="bi bi-heart-fill"></i> {{ $outfitseller->outfit->liked }}
                    </a>
                </div>
                @if($outfitseller->description)
                    <div class="mb-3">
                        {!! $outfitseller->description !!}
                    </div>
                @endif



            </div>
        </div>
        <div class="my-3">
            <div class="d-block h2 fw-bold mb-3">
                <p>Analyze prices of other sellers</p>
            </div>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                @foreach($outfits as $outfit)
                    @foreach($outfit->outfitsellers as $item)
                    @if($item->seller_id == $outfitseller->seller_id)

                    @else 
                        <div class="col">
                            <div>
                                <div>
                                    <div>    
                                        <img src="{{ asset('img/temp/outfit.png') }}" alt="" class="img-fluid border rounded"> 
                                    </div>
                                    <a href="{{ route('admin.outfit.show', [$outfit->id, $item->seller_id]) }}" class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
                                        {{ $outfit->name() }}
                                    </a>
                                        <p>@lang('app.Price'): {{$item->price}}</p>
                                        <p>@lang('app.Seller'): {{$item->seller->name}}</p>
                                        <p>@lang('app.Company'): {{$item->seller->company_name}}</p>
                                        <p>@lang('app.description'): {{$item->description()}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection