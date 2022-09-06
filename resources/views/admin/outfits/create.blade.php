@extends('front.layouts.app')
@section('title') @lang('app.outfit') - @lang('app.create') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger text-center border-bottom py-2 mb-3">
            @lang('app.outfit') - @lang('app.create')
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('admin.outfit.store') }}" method="post" enctype="multipart/form-data" class="col-md-6 col-lg-4">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">
                        @lang('app.name')
                    </label>
                    <textarea class="form-control @error('name') is-invalid @enderror" name="name" id="name" rows="3" maxlength="2550"></textarea>
                    @error('name')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name_en" class="form-label fw-bold">
                        @lang('app.name_en')
                    </label>
                    <textarea class="form-control @error('name_en') is-invalid @enderror" name="name_en" id="name_en" rows="3" maxlength="2550"></textarea>
                    @error('name_en')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>




                <div class="mb-3">
                    <label for="age_id" class="form-label fw-bold">
                        @lang('app.age') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('age_id') is-invalid @enderror" id="age_id" name="age_id" required>
                        @foreach($ages as $age)
                            <option value="{{ $age->id }}">
                                {{ $age->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('age_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>



                
                <div class="mb-3">
                    <label for="seller_id" class="form-label fw-bold">
                        @lang('app.seller') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('seller_id') is-invalid @enderror"  id="seller_id" name="seller_id" required>
                        @foreach($sellers as $seller)
                            <option value="{{ $seller->id }}">
                                {{ $seller->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('age_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="tag_id" class="form-label fw-bold">
                        @lang('app.tag') <span class="text-danger">*</span>
                    </label>
                        @foreach($tags as $tag)
                        <input class="form-check-input" type="checkbox" id="flexCheck-v-{{ $tag->id }}" name="tags[]"
                        value="{{ $tag->id }}"  >>
                        <label class="form-check-label" for="flexCheck-v-{{ $tag->id }}">{{ $tag->name }}</label>
                        @endforeach

                    @error('age_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>







                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">
                        @lang('app.description')
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" maxlength="2550"></textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description_en" class="form-label fw-bold">
                        @lang('app.description_en')
                    </label>
                    <textarea class="form-control @error('description_en') is-invalid @enderror" name="description_en" id="description_en" rows="3" maxlength="2550"></textarea>
                    @error('description_en')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

            <div class="mb-3">
                <label for="price" class="form-label fw-bold">
                    @lang('app.price') <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" min="0" step="0.1" required>
                @error('price')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

                <div class="mb-3">
                    <label for="stock" class="form-label fw-bold">
                        @lang('app.stock') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock"  min="0" required>
                    @error('stock')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sold" class="form-label fw-bold">
                        @lang('app.sold') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('sold') is-invalid @enderror" name="sold" id="sold"  min="0" required>
                    @error('sold')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_percent" class="form-label fw-bold">
                        @lang('app.discount-percent') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" name="discount_percent" id="discount_percent"  min="0" required>
                    @error('discount_percent')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>




                <div class="mb-3">
                    <label for="discount_datetime_start" class="form-label fw-bold">
                        @lang('app.discount-datetime-start') <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" class="form-control @error('discount_datetime_start') is-invalid @enderror" name="discount_datetime_start" id="discount_datetime_start" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    @error('discount_datetime_start')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_datetime_end" class="form-label fw-bold">
                        @lang('app.discount-datetime-end') <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" class="form-control @error('discount_datetime_end') is-invalid @enderror" name="discount_datetime_end" id="discount_datetime_end" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    @error('discount_datetime_end')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>




















                @foreach($options as $option)
                    <div class="mb-3">
                        <label for="option_{{ $option->id }}" class="form-label fw-bold">
                            {{ $option->name }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('values_id') is-invalid @enderror" id="option_{{ $option->id }}" name="values_id[]" required>
                            @foreach($option->values as $value)
                                <option value="{{ $value->id }}">
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('values_id')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                @endforeach

                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">@lang('app.image') (500x500)</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/jpeg">
                    @error('image')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="credit" id="credit" value="1">
                        <label class="form-check-label" for="credit">
                            @lang('app.credit')
                        </label>
                        @error('credit')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="recommend" id="recommend" value="1">
                        <label class="form-check-label" for="recommend">
                            @lang('app.recommend')
                        </label>
                        @error('recommend')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i> @lang('app.store')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection