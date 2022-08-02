
@extends('layouts.layout')

@section('content')
<h1 style="text-align: center; 
                        color: white; 
                        margin-top: 20px;">PÁGINA DE DESCRIÇÃO</h1>


<div class="card mb-3" style=" width: 1300px;
                                ;
                                margin-left: 50px;
                                background-color: #212529;">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="{{ $movie->image }}" style="height: 400px" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title" style="color: white;">{{ $movie->name }}</h5>
                <p class="card-text" style="color: white;">{{ $movie->description }}</p>
            </div>
            <div style="color: white;"><b>Categoria:</b>
                <p style="display: inline-block;">{{ $movie->tags }}</p> <br>
                <b style="color: white;">Classificação:</b>
                <p style="display: inline-block;">{{ $movie->classification }}</p>
            </div>
            @if ($sessions->isEmpty())
                <br>
                <h3 style="color: white;">Não há Sessões Disponíveis</h3>
            @else
                <h3 style="color: white;">Sessões Cadastradas</h3>
                <table class="table table-dark">
                    <thead>
                        <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Duração</th>
                        <th scope="col">Sala</th>
                        </tr>
                    </thead>
                        @foreach($sessions as $session)
                            <tbody>
                                <tr>
                                <td>{{ $session->date }}</td>
                                <td>{{ $session->time }}</td>
                                <td>{{ $session->duration }}</td>
                                <td>{{ $session->roomName }}</td>
                                </tr>
                            </tbody>
                        @endforeach
            @endif
                
            </table>
        </div>
    </div>   
</div>


@endsection