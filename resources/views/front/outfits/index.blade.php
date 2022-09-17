@extends('front.layouts.app')
@section('content')
    <div class="row py-2 align-item-center justify-content-center">
        <div class="col-6">
            <form action="{{ route('outfits.home') }}">
                <input class="form-control form-control-sm" type="text" placeholder="@lang('app.search')"
                    aria-label="@lang('app.search')" name="q">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            {{-- category start --}}
            <div class="container-fluid mt-3">
                @foreach ($categories as $category)
                    <div class="btn-group dropend mx-2">
                        <a href="{{ route('outfits.home', ['c' => $category->id]) }}">
                            <button type="button"
                                class="btn btn-secondary {{ $category_id == $category->id ? 'bg-danger' : '' }}"
                                style="width: 150px;">
                                {{ $category->name() }}
                            </button>
                        </a>
                        @if ($category->children->count() > 0)
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropright</span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($category->children as $child)
                                    <li>
                                        <a href="{{ route('outfits.home', ['c' => $child->id]) }}">
                                            <button
                                                class="btn container-fluid btn-secondary {{ $category_id == $child->id ? 'bg-danger' : '' }}">
                                                {{ $child->name() }}
                                            </button>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
            {{-- category end --}}
        </div>



        <div class="col-{{$options != null?'9':'11'}}">
            <div class="container">
                <div class="container py-3">
                    @if ($search)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
                            <span class="d-block h4 mb-0 text-danger">{{ $search }}</span>
                            <span class="d-block"><i class="bi bi-chevron-right"></i></span>
                        </div>
                    @endif
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                        @foreach ($outfits as $outfit)
                            <div class="col">
                                @include('front.app.outfit')
                            </div>
                        @endforeach
                    </div>
                    {{ $outfits->links() }}
                </div>

            </div>
        </div>
        @if ($options != null)
            <div class="col-2">
                <div class="container-fluid py-3">
                    <div class="d-grid gap-2 mr-3">
                        @include('front.app.filter')
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
