@extends('front.layouts.app')
@section('content')

            @if($outfits!=null)
            <div class="container-xxl py-3">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                    @foreach($outfits as $outfit)
                        <div class="col">
                            @include('front.app.outfit')
                        </div>
                    @endforeach
                </div>
                {{ $outfits->links() }}
            </div>
            @endif
    
@endsection