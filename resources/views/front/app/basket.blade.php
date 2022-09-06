@extends('front.layouts.app')
@section('content')
        @if($outfitsellers->count() > 0)

            @foreach($outfitsellers as $outfitseller)
            <div class="container-sm py-3">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
                    <a href="{{ route('outfit.show', [ $outfitseller->outfit->id, $outfitseller->seller->id]) }}" class="position-relative d-flex justify-content-start align-items-center">
                        <div class="h4 text-danger">{{ $outfitseller->outfit->name }}</div>
                    </a>
                </div>
                <div class="row g-3">
                    <div class="col-lg-2 col-sm-4 col-md-4">
                        <div class="position-relative d-flex justify-content-center align-items-center">
                            <a href="{{ route('outfit.show', [ $outfitseller->outfit->id, $outfitseller->seller->id]) }}" class="position-relative d-flex justify-content-center align-items-center">
                            <img src="{{ $outfitseller->outfit->image() }}" alt="" class="img-fluid border rounded">
                            </a>
                        </div>
                    </div>
                    <div class="col-9 col-sm-7 col-md-7">
                        <div class="h5 fw-bold mb-3">
                            <p @disabled(true) class="d-none">{{$total_price += $outfitseller->price}}</p>
                            <p>{{$outfitseller->price}}</p>
                            <p>{{$outfitseller->description()}}</p>
                            @foreach ($outfitseller->outfit->tags as $tag)
                                <span>{{$tag->name(). '/'}} </span>
                            @endforeach
                            @if($outfitseller->outfit->credit)
                                <i class="bi bi-patch-check-fill text-info"></i>
                            @endif
                        </div>
                        <div class="d-flex align-items-center fw-bold mb-3">
                            <div class="me-4">
                                <i class="bi bi-basket-fill text-black-50"></i> {{ $outfitseller->outfit->sold }}
                            </div>
                            <div class="me-4">
                                <i class="bi bi-binoculars-fill text-black-50"></i> {{ $outfitseller->outfit->viewed }}
                            </div>
                            <a href="#" class="btn btn-danger btn-sm text-decoration-none">
                                <i class="bi bi-heart-fill"></i> {{ $outfitseller->outfit->favorited }}
                            </a>
                        </div>
                    </div>

                    <div class="col-1">
                        <a href="{{ route('add_to_basket', $outfitseller->id) }}">
                            @if (!in_array($outfitseller->id, $basket))
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill"></i></button>
                                </div>
                            @elseif(in_array($outfitseller->id, $basket))
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-lg btn-danger"><i class="bi bi-dash-square"></i></button>
                                </div>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="my-3">
                {{ $outfitsellers->links() }}
            </div>


            <div class="input-group container-lg my-3">
                <span class="input-group-text">Jemi:</span>
                <input type="text" class="form-control" value='{{ number_format($total_price, 2, ".", " ") }}' aria-label="Dollar amount (with dot and two decimal places)">
                <span class="input-group-text">TMT</span>
            </div>

            <div class="container-lg my-3">
                <form action='{{route('set_order')}}' method='POST'>
                    @csrf
                    <div class="mb-3">
                        <label for="location" class="form-label">@lang('app.location')</label>
                        <select name="location_id" id="" class="form-select">
                            @foreach ($locations as $location)
                                <option value="{{$location->id}}">
                                    {{$location->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                    <label for="address" class="form-label">yashayan yeriniz</label>
                    <input type="text" class="form-control" id="last_name" name="address" >
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">telefon belginiz</label>
                        <input type="numeric" class="form-control" id="phone" value='{{auth()->user()->phone?:""}}' name="phone" >
                    </div>
                    <div class="input-group my-3">
                        <span class="input-group-text">goshmaca maglumat</span>
                        <textarea class="form-control" name='note' aria-label="With textarea"></textarea>
                    </div>
                            <button type="submit" class="btn btn-primary">ugrat</button>
                </form>
            </div>
        @else
            <div class="p-5 h2 mb-0 text-center">
                @lang('app.not-found', ['name' => 'Product'])
            </div>
        @endif

        <div id="firsttry">

        </div>

        {{-- <script>
            $(document).ready(function () {
                fetchi();


                function fetchi(){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        type: "GET",
                        url: "/some",
                        data: { somefield: "Some field value", _token: '{{csrf_token()}}' },
                        dataType: "json",
                        success: function (response) {
                            // console.log(response.result); 
                            $.each(response.result, function (key, item) { 
                                 $('#firsttry').append('\
                                     <h2>'+item.name+'</h2>\
                                 ');
                            });
                        },
                        error: function (data, textStatus, errorThrown) {
                        console.log(data);

                    },
                    });
                }
            });
        </script> --}}
@endsection