<form action="{{ url()->current() }}" method="get">

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-c">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-c" aria-expanded="true" aria-controls="panelsStayOpen-collapse-c">
                    @lang('app.ages')
                </button>
            </h2>
            <div id="panelsStayOpen-collapse-c" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading-c">
                <div class="accordion-body px-2 py-1">
                    @foreach($ages as $age)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-c-{{ $age->id }}" name="ages[]"
                                value="{{ $age->id }}" {{ $f_ages->contains($age->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck-c-{{ $age->id }}">{{ $age->name() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        @foreach($options as $option)
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading-o{{ $option->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-o{{ $option->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse-o{{ $option->id }}">
                        {{ $option->name() }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse-o{{ $option->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-o{{ $option->id }}">
                    <div class="accordion-body px-2 py-1">
                        @foreach($option->values as $value)
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" id="flexCheck-v-{{ $value->id }}" name="v[{{ $option->id }}][]"
                                       value="{{ $value->id }}" {{ $f_values->contains($value->id) ? 'checked' : '' }} >>
                                <label class="form-check-label" for="flexCheck-v-{{ $value->id }}">{{ $value->name() }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="container-lg">
        <div class="row g-2 my-1">
            <div class="col">
                <button type="submit" class="btn btn-danger btn-sm w-100"><i class="bi bi-funnel-fill"></i></button>
            </div>
            <div class="col">
                <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm w-100"><i class="bi bi-trash-fill"></i></a>
            </div>
        </div>
    </div>
</form>