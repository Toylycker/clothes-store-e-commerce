@extends('admin.layouts.app')
@section('title') @lang('app.tags') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.tags')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.tags.index') }}"
               onclick="event.preventDefault(); document.getElementById('tagsForm').submit();">
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
                <form action="{{ route('admin.tags.index') }}" id="tagForm">
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
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->name_en }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $tags->links() }}
@endsection