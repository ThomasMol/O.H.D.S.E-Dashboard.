@extends('layout')
@section('title','Contributie')
@section('content')
<header>
    <h1 class="d-inline">Contributie toevoegen</h3>
        <div class="dropdown float-right">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownJaar"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Begroting van jaargang {{$bestuursjaar->jaargang}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownJaar">

                @foreach($bestuursjaren as $bestuursjaar_value)
                <a class="dropdown-item @if($bestuursjaar_value->jaargang == $bestuursjaar->jaargang ) active @endif"
                    href="/contributies/toevoegen/{{$bestuursjaar_value->jaargang}}">Jaar
                    {{$bestuursjaar_value->jaargang}}
                    @if($bestuursjaar_value->jaargang == $huidig_jaar->jaargang) (Huidig jaar)@endif</a>
                @endforeach
            </div>
        </div>
</header>


<form method="POST" action="/contributies">
    @csrf
    @include('contributies.form')
</form>

@endsection
