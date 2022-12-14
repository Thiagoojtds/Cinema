

@extends('layouts.layout')

@section('content')


@if(!empty($movies->toArray()))
    <h1 style="text-align: center;
                color: white;
                margin-top: 10px">FILMES DISPONÍVEIS</h1>
@else
    <h1 style="text-align: center;
                color: white;
                margin-top: 10px">NÃO HÁ FILMES PARA ESSA BUSCA</h1>
@endif

    @foreach($movies as $movie)
    
        <div class="card" style="width: 200px;
                                background-color: #212529;
                                margin: 0.5rem;
                                display: inline-block">
        <div class="bg-image hover-zoom">
            <img src="{{ $movie['image'] }}"  class="w-500" style="width: 198px;
                                                                    height: 300px;" >
        </div>
        
        <div class="card-body" >
            <h5 class="card-title" style="color: white;">{{ $movie['name'] }}</h5>
            <p class="card-text"style=" color: white;
                                        overflow: hidden;
                                        display: -webkit-box;
                                        -webkit-line-clamp: 3;
                                        -webkit-box-orient: vertical;">{{ $movie['description'] }}</p>
            <a href="{{ route('description', $movie) }}" class="btn btn-outline-danger" style="margin-left: 20px;">Ver Sessões</a>
        </div>
        </div>

    @endforeach

    </div>
</div>

@endsection

