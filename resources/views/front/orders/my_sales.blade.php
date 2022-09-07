@extends('front.layouts.app')
@section('title') @lang('app.outfit') - @lang('app.my_orders') @endsection
@section('content')
@if($orders->count() > 0)
    @foreach ($orders as $order)
    <div class="container-sm py-3">
        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">           
                <div class="h4 text-danger">@lang('app.order_number')  {{ $order[0]->order->order_num }} items num: {{$order->count()}}</div>
        </div>
        @foreach ($order as $detail)
        <div class="row g-3">
            <div class="col-lg-2 col-sm-4 col-md-4 mb-3">
                <div class="position-relative d-flex justify-content-center align-items-center">
                    <a href="{{ route('outfit.show', [ $detail->outfit->id, $detail->outfit->seller->id]) }}" class="position-relative d-flex justify-content-center align-items-center">
                    <img src="{{ $detail->outfit->image() }}" alt="" class="img-fluid border rounded">
                    </a>
                </div>
            </div>


            <div class="col-9 col-sm-7 col-md-7 mb-3">
                <div class="h5 fw-bold mb-3">
                    <p>{{$detail->outfit->name()}}</p>
                    <p>{{$detail->outfit->price}}</p>
                    <p>{{$detail->outfit->description()}}</p>
                    @foreach ($detail->outfit->tags as $tag)
                        <span>{{$tag->name(). '/'}} </span>
                    @endforeach
                    @if($detail->outfit->credit)
                        <i class="bi bi-patch-check-fill text-info"></i>
                    @endif
                </div>
                <div class="d-flex align-items-center fw-bold mb-3">
                    <div class="me-4">
                        <i class="bi bi-basket-fill text-black-50"></i> {{ $detail->outfit->sold }}
                    </div>
                    <div class="me-4">
                        <i class="bi bi-binoculars-fill text-black-50"></i> {{ $detail->outfit->viewed }}
                    </div>
                    <a href="#" class="btn btn-danger btn-sm text-decoration-none">
                        <i class="bi bi-heart-fill"></i> {{ $detail->outfit->favorited }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    <div class="my-3">
        {{ $orders->links() }}
    </div>
@else
    <div class="p-5 h2 mb-0 text-center">
        <b>@lang('app.order')</b> @lang('app.not-found')
    </div>
@endif



@endsection