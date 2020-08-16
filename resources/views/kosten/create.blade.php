@extends('layout')
@section('title','Overige kosten')
@section('content')
<header>
    <h1 class="d-lg-inline">Overige kosten toevoegen</h3>
        <div class="dropdown float-lg-right">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownJaar"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Begroting van jaargang {{$bestuursjaar->jaargang}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownJaar">

                @foreach($bestuursjaren as $bestuursjaar_value)
                <a class="dropdown-item @if($bestuursjaar_value->jaargang == $bestuursjaar->jaargang ) active @endif"
                    href="/kosten/toevoegen/{{$bestuursjaar_value->jaargang}}">Jaar
                    {{$bestuursjaar_value->jaargang}}
                    @if($bestuursjaar_value->jaargang == $huidig_jaar->jaargang) (Huidig jaar)@endif</a>
                @endforeach
            </div>
        </div>
</header>
<div class="card">
    <form class="card-body" method="POST" action="/kosten">
        @csrf
        @include('kosten.form')
    </form>

</div>
@endsection
