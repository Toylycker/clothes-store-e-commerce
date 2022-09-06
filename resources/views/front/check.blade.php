@extends('front.layouts.app')
@section('content')
{{$outfit->image()}}

<div class="position-relative d-flex justify-content-center align-items-center">
    <img src="{{$outfit->image()}}" alt="" class="img-fluid border rounded">
    <img src="{{ Storage::url("/storage/app/outfits/{$outfit->image}") }}"class="img-fluid border rounded"  alt="{{ $outfit->image }}" />
    <img src="{{ Storage::url("/storage/app/public/outfits/{$outfit->image}") }}"class="img-fluid border rounded"  alt="{{ $outfit->image }}" />
    <img src="{{ Storage::url("/storage/outfits/{$outfit->image}") }}"class="img-fluid border rounded"  alt="{{ $outfit->image }}" />
    <img src="{{ Storage::url("/storage/app/{$outfit->image}") }}"class="img-fluid border rounded"  alt="{{ $outfit->image }}" />
</div>
@endsection