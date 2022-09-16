<div class="mt-2">
  <button id="somebutton{{$outfit->id}}">bas</button>
    <!-- Button trigger modal -->
    <div class="d-grid gap-2">
        <button type="button" id="button{{ $outfit->id }}" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#exampleModal{{ $outfit->id }}">
            <i class="bi bi-plus-square-fill"></i>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal{{ $outfit->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_body_{{ $outfit->id }}">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
                $('{{ '#button' . $outfit->id }}').click(function() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            url: '/outfits/home/variations',
                            data: {
                                outfit_id: '{{$outfit->id}}',
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(data) {
                                // $('{{ '#modal_body_' . $outfit->id }}').append('<h1>success</h1>');
                                $('{{ '#modal_body_' . $outfit->id }}').html('');
                                data.forEach(element => {
                                    option ='';
                                    variation = '<h1>' + element.name + '</h1> <br>';
                                    element.variation_options.forEach(el=>{
                                      console.log(el);
                                      if (el.outfit_items.length >0) {
                                        id = el.id
                                        option += '<div class = "col btn border option'+ el.id +'">'+'<a href="/outfits/home/variations/'+el.id+'/choose">' + el.option +'</a>'+'</div>';
                                      }else{
                                        option += '<div class = "col btn border bg-secondary">' +  el.option + '</div>';
                                      }
                                    });
                                    // foreach ended -------------------------------------------------------------
                                  $('{{ '#modal_body_' . $outfit->id }}').append(variation+'<row>'+option+'</row>');
                                });
                              },
                              error: function(data, textStatus, errorThrown) {
                                alert(errorThrown);
                              },
                            });
                          });
                        })
</script>
