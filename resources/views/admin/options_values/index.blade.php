@extends('admin.layouts.app')
@section('title') @lang('app.outfits') @endsection
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">@lang('app.optionvalues')</h1>
    <a href="admin.options.create" class="btn bg-success mx-3 my-2">add Option</a>
</div>
<div class="container py-3">      
    @foreach($options as $option)
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-o{{ $option->id }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-o{{ $option->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse-o{{ $option->id }}">
                    <h4>name:{{ $option->name }} | name_en: {{ $option->name_en }} | sort_order: {{ $option->sort_order }}</h4>
                </button>
            </h2>
            {{-- making changes --}}
                <div class="container">
                    <div class="row  justify-content-start">
                        {{-- 1 --}}
                        <div class="col mb-3 justify-self-start">
                            <div class="container">
                                <form action="{{route("admin.options.destroy", $option->id)}}" method="post">
                                    @csrf
                                    @method('Delete')
                                    <button type="submit" class="btn bg-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="col mb-3 justify-self-start">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                edit
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    ...
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>                 
                        </div>       
                        {{-- 3 --}}
                        <div class="col mb-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                add Value
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    ...
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>                 
                        </div>       
                    </div>
                </div>

            <div id="panelsStayOpen-collapse-o{{ $option->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-o{{ $option->id }}">
                <div class="accordion-body px-2 py-1">
                    @foreach($option->values as $value)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-v-{{ $value->id }}" name="v[{{ $option->id }}][]"
                                   value="{{ $value->id }}" >>
                            <label class="form-check-label" for="flexCheck-v-{{ $value->id }}">
                                <h6>name:{{ $value->name }} | name_en: {{ $value->name_en }} | sort_order: {{ $value->sort_order }}</h6>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

</div>
{{-- <div class="container-lg">
    <div class="row g-2 my-1">
        <div class="col">
            <button type="submit" class="btn btn-danger btn-sm w-100"><i class="bi bi-funnel-fill"></i></button>
        </div>
        <div class="col">
            <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm w-100"><i class="bi bi-trash-fill"></i></a>
        </div>
    </div>
</div> --}}
</form>
</div>
@endsection