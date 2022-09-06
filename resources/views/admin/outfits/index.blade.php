@extends('admin.layouts.app')
@section('title') @lang('app.outfits') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.outfits')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.outfits.index') }}"
               onclick="event.preventDefault(); document.getElementById('outfitForm').submit();">
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
                <td>values</td>
                <td>slug</td>
                {{-- <td>description</td>
                <td>description_en</td> --}}
                <td>viewed</td>
                <td>recommended</td>
                <td>liked</td>
                {{-- <td>Requests</td> --}}
                <td>Created at</td>
                <td>Updated at</td>
            </tr>
            <tr>
                <form action="{{ route('admin.outfits.index') }}" id="outfitForm">
                <td>
                    <input type="text" class="form-control form-control-sm @error('id') is-invalid @enderror" name="id" id="id" value="{{ $id }}" maxlength="15">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" id="name" value="{{ $name }}" maxlength="15">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('name_en') is-invalid @enderror" name="name_en" id="name_en" value="{{ $name_en }}" maxlength="15">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('value') is-invalid @enderror" name="value" id="value" value="{{ $value }}" maxlength="15">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" name="slug" id="slug" value="{{ $slug }}" maxlength="15">
                </td>
                {{-- <td>
                    <input type="text" class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" id="description" value="{{ $description }}" maxlength="15">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('description_en') is-invalid @enderror" name="description_en" id="description_en" value="{{ $description_en }}" maxlength="15">
                </td> --}}
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="viewed" id="viewed" value="1" {{ $viewed ? 'checked':'' }}>
                        <label class="form-check-label" for="viewed">
                            viewed
                        </label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="recommended" id="recommended" value="1" {{ $recommended ? 'checked':'' }}>
                        <label class="form-check-label" for="recommended">
                            recommended
                        </label>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="liked" id="liked" value="1" {{ $liked ? 'checked':'' }}>
                        <label class="form-check-label" for="liked">
                            liked
                        </label>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('created_at') is-invalid @enderror" name="created_at" id="created_at" value="{{ $createdAt }}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm @error('updated_at') is-invalid @enderror" name="updated_at" id="updated_at" value="{{ $updatedAt }}">
                </td>
                </form>
            </tr>
            </thead>
            <tbody>
            @forelse($outfits as $outfit)
                <tr>
                    <td>{{ $outfit->id }}</td>
                    <td>{{ $outfit->name }}</td>
                    <td>{{ $outfit->name_en }}</td>
                    <td>@foreach ($outfit->values as $value)
                        <p>{{$value->option->name . ':' . $value->name}}</p> 
                    @endforeach</td>
                    <td>{{ $outfit->slug }}</td>
                    {{-- <td>{{ $outfit->description }}</td>
                    <td>{{ $outfit->description_en }}</td> --}}
                    <td>{{ $outfit->viewed ? 'Yes':'No' }}</td>
                    <td>{{ $outfit->recommended ? 'Yes':'No' }}</td>
                    <td>{{ $outfit->liked ? 'Yes':'No' }}</td>
                    {{-- <td>{{ $visitor->requests }}</td> --}}
                    <td>{{ $outfit->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $outfit->updated_at->format('Y-m-d H:i:s') }}</td>
                    <td><div>
                        <a href="{{route('admin.outfit.show', [$outfit->id, $outfit->outfitsellers[0]->seller_id])}}" class="btn btn-success btn-sm">for edit or delete</i></a>
                    </div></td>
                    {{-- <td>
                        <div>
                            <a href="{{ route('admin.outfit.edit', $outfit->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                        </div>
                    </td>
                    <td>
                        <form action="#" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary py-1 px-2"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $outfits->links() }}
@endsection