@extends('admin.layouts.app')
@section('title') @lang('app.sellers') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.sellers')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.sellers.index') }}"
               onclick="event.preventDefault(); document.getElementById('sellerForm').submit();">
                Submit
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-striped">
            <thead>
            <tr class="fw-bold">
                <td>ID</td>
                <td>user_id</td>
                <td>location</td>
                <td>name</td>
                <td>last name</td>
                <td>phone</td>
                <td>address</td>
                <td>company name</td>
            </tr>
            <tr>
                <form action="{{ route('admin.sellers.index') }}" id="sellerForm">
                    <td>
                        <input type="text" class="form-control form-control-sm @error('id') is-invalid @enderror" name="id" id="id" value="{{ $id }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('user_id') is-invalid @enderror" name="user_id" id="user_id" value="{{ $user_id }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('location') is-invalid @enderror" name="location" id="location" value="{{ $location }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" id="name" value="{{ $name }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ $last_name }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('phone]') is-invalid @enderror" name="phone" id="phone" value="{{ $phone }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('address]') is-invalid @enderror" name="address" id="address" value="{{ $address }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('company_name]') is-invalid @enderror" name="company_name" id="company_name" value="{{ $company_name }}" maxlength="10">
                    </td>
                </form>
            </tr>
            </thead>
            <tbody>
            @forelse($sellers as $seller)
                <tr>
                    <td>{{ $seller->id }}</td>
                    <td>{{ $seller->user_id}}</td>
                    <td>{{ $seller->location->name}}</td>
                    <td>{{ $seller->name}}</td>
                    <td>{{ $seller->last_name}}</td>
                    <td>{{ $seller->phone}}</td>
                    <td>{{ $seller->address}}</td>
                    <td>{{ $seller->company_name}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $sellers->links() }}
@endsection