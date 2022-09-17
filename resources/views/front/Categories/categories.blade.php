@extends('front.layouts.app')
@section('title')
    @lang('app.outfit') - @lang('app.my_orders')
@endsection
@section('content')
    <div class="container-fluid mt-3">
        @foreach ($categories as $category)
            <div class="btn-group dropend mx-3">
                <a href="{{ route('categories', ['c' => $category->id]) }}">
                    <button type="button" class="btn btn-secondary" style="width: 150px;">
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
                                <a href="{{ route('categories', ['c' => $child->id]) }}"> {{ $child->name() }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>


    <div class="container-sm">
        @if ($options->count() > 0)
            @include('front.app.filter')
        @endif
    </div>
@endsection
