@extends('admin.layouts.app')
@section('title') @lang('app.visitors') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.ages')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.ages.index') }}"
               onclick="event.preventDefault(); document.getElementById('ageForm').submit();">
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
            </tr>
            <tr>
                <form action="{{ route('admin.ages.index') }}" id="ageForm">
                <td>
                    <input type="text" class="form-control form-control-sm @error('id') is-invalid @enderror" name="id" id="id" value="{{ $id }}" maxlength="10">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" id="name" value="{{ $name }}" maxlength="10">
                </td>
                
                </form>
            </tr>
            </thead>
            <tbody>
            @forelse($ages as $age)
                <tr>
                    <td>{{ $age->id }}</td>
                    <td>{{ $age->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $ages->links() }}
@endsection