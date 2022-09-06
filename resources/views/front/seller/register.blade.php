@extends('front.layouts.app')
@section('title') @lang('app.register') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger text-center border-bottom py-2 mb-3">
            @lang('app.register')
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-6 col-lg-4">
                <form action="{{ route('seller.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('app.name')</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" autofocus>
                        @error('name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">@lang('app.last_name')</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" autocomplete="off" aria-describedby="last_nameHelp">
                        @error('last_name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">@lang('app.company_name')</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" autocomplete="off" aria-describedby="company_nameHelp">
                        @error('company_name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location_id" class="form-label fw-bold">
                            @lang('app.location') <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" >
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">@lang('app.address')</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" autofocus>
                        @error('address')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">@lang('app.phone')</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" autofocus>
                        @error('phone')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> @lang('app.register')
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection