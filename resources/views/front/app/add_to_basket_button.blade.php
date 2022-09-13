<div class="mt-2">
<!-- Button trigger modal -->
<div class="d-grid gap-2">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{$outfit->id}}">
        <i class="bi bi-plus-square-fill"></i>{{$outfit->variations->count()}}
      </button>
</div>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{$outfit->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @foreach ($outfit->variations as $variation)
              <h3>{{$variation->name}}</h3>
              <br>
              <div class="row">
                  @foreach ($variation->variation_options as $ooption)
                      <div class="col btn border">
                        <a href="{{route('variationchoosing', ['variation_id'=>$variation->id, 'option_id'=>$ooption->id, 'outfit_id'=>$outfit->id])}}">
                            {{$ooption->option}}
                        </a>
                      </div>
                  @endforeach
              </div>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  
</div>




{{-- 
ProductItem::where('outfit_id', $request->outfit_id)->whereHas('variation_options', function ($query){
    $query->where('id', option1);
})

VariationOption->where('id', $id)->with('outfit_items') --}}