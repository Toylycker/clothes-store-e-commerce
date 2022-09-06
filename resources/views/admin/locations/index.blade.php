@extends('admin.layouts.app')
@section('title') @lang('app.locations') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.locations')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.locations.index') }}"
               onclick="event.preventDefault(); document.getElementById('locationForm').submit();">
                Submit
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-striped">
            <thead>
            <tr class="fw-bold">
                <td>ID</td>
                <td>name</td>
                <td>name_en</td>
                
            </tr>
            <tr>
                <form action="{{ route('admin.locations.index') }}" id="locationForm">
                <td>
                    <input type="text" class="form-control form-control-sm @error('id') is-invalid @enderror" name="id" id="id" value="{{ $id }}" maxlength="10">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" id="name" value="{{ $name }}" maxlength="10">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name_en" id="name_en" value="{{ $name_en }}" maxlength="10">
                </td>
                
                </form>
            </tr>
            </thead>
            <tbody>
            @forelse($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->name_en }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $locations->links() }}
@endsection