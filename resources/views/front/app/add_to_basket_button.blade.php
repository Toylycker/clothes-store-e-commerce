<div class="mt-2">
    <a href="{{ route('add_to_basket', $outfit->id) }}">
        @if (!in_array($outfit->id, $basket))
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill"></i></button>
            </div>
        @elseif(in_array($outfit->id, $basket))
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-danger"><i class="bi bi-dash-square"></i></button>
            </div>
        @endif
    </a>
</div>