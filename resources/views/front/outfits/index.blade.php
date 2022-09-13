@extends('front.layouts.app')
@section('content')

<div class="row py-2 align-item-center justify-content-center">
    <div class="col-6">
        <form action="{{ route('outfits.home') }}">
            <input class="form-control form-control-sm" type="text" placeholder="@lang('app.search')" aria-label="@lang('app.search')" name="q" >
        </form>
    </div>
</div>

<div class="container-xxl py-3">
    <div class="d-grid gap-2 col-6 mx-auto">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Filter</button>
    </div>
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Filter</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('front.app.filter')
        </div>
      </div>
    </div>
  </div>

        <div class="container-fluid">
            <div class="container-xxl py-3">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
                    <span class="d-block h4 mb-0 text-danger">{{$search}}</span>
                    <span class="d-block"><i class="bi bi-chevron-right"></i></span>
                </div>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                    @foreach($outfits as $outfit)
                        <div class="col">
                            @include('front.app.outfit')
                        </div>
                    @endforeach
                </div>
                {{ $outfits->links() }}
            </div>
        
        </div>
</div>
    
@endsection