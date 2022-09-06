@extends('front.layouts.app')
@section('content')

<div class="container-xxl align-item-center justify-content-center">
    <h3>Geyinjek online dukana hosh geldiniz. Siz eshigi name etmek isleyaniz?</h3>
</div>
<div class="container-xxl align-item-center justify-content-center">
    <div class="row">
        <div class="col bg-danger">
            <h3>Satjak</h3>
        </div>
        <div class="col bg-success">
            <a href="{{route('outfits.home')}}">
                <h3>Aljak</h3>
            </a>
        </div>
    </div>
</div>

    
@endsection