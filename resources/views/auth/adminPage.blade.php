<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body >

<?php

use App\Models\Movie;
use App\Models\Room;
use App\Models\Session;

$movies = Movie::get();
$rooms = Room::get();
$sessions = Session::join('movies', 'movie_id', '=', 'movies.id')
                    ->join('rooms', 'room_id', '=', 'rooms.id')
                    ->select('sessions.id', 'sessions.movie_id', 'sessions.room_id', 'sessions.date','sessions.time' ,'movies.name AS movieName', 'rooms.name AS roomName', 'movies.duration AS movieDuration')
                    ->get();
//dd($sessions);

?>

@extends('layouts.layout')

@section('content')



<h1 style="text-align: center;
            margin-top: 20px;
            color: white;">PÁGINA DE ADMIN</h1>

<div style="text-align: center;
            margin-top: 20px;">
    <p>
    <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
        Adicionar um filme
    </a>
    </p>
    <div class="collapse" id="collapseExample1">
    <div class="card card-body" style="width:800px; 
                                        margin:0 auto;
                                        background-color: #212529;
                                        color: white;">
        <form method="POST" action="{{ route('storeMovie') }}">
            @csrf
            <div class="form-group">
                <label for="MovieName">Nome do Filme</label>
                <input type="text" class="form-control" id="MovieName" name="name">
            </div>
            <div class="form-group">
                <label for="Duration">Duração</label><br>
                <input type="time" name="duration" id="Duration" step="1"></input>
            </div><br>
            <div class="form-group">
                <label for="MovieDescription">Descrição</label>
                <textarea class="form-control" minlength="52" id="MovieDescription" name="description" rows="4" cols="50" ></textarea>
            </div>
            <div class="form-group">
                <label for="MovieImage">Imagem</label>
                <input type="url" class="form-control" id="MovieImage" name="image">
            </div>
            <div class="form-group">
                <label for="MovieTags">Tags</label>
                <input type="search" class="form-control" id="MovieTags" name="tags">
            </div><br>
            <div class="form-group">
                <label for="MovieClassification">Classificação indicativa</label>
                <input type="search" class="form-control" id="MovieClassification" name="classification">
            </div><br>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    </div>
    <p>
    <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
        Criar uma sala
    </a>
    </p>
    <div class="collapse" id="collapseExample2">
    <div class="card card-body" style="width:800px; 
                                        margin:0 auto;
                                        background-color: #212529;
                                        color: white;">
    <form method="POST" action="{{ route('storeRoom') }}">
        @csrf
            <div class="form-group">
                <label for="SessionName">Nome da sala</label>
                <input type="text" class="form-control" id="SessionName" name='name'placeholder="Sala 00">
            </div><br>
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
    </div>
    </div>
    <p>
    <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
        Criar uma sessão
    </a>
    </p>
    <div class="collapse" id="collapseExample3">
    <div class="card card-body" style="width:800px; 
                                        margin:0 auto;
                                        background-color: #212529;
                                        color: white;">
    <form method="POST" action="">
        @csrf
            <div class="form-group">
                <label>Filme que sera exibido</label>
                <select class="form-control" name="movie_id">
                    @foreach($movies as $movie)
                        <option>{{ $movie->name }}</option>
                    @endforeach
                </select>
            </div><br>

            <div class="form-group">
                <label >Sala que sera exibido</label>
                <select class="form-control" name="room_id">
                    @foreach($rooms as $room)
                        <option>{{ $room->name }}</option>
                    @endforeach
                </select>
            </div><br>

            <div class="form-group">
                <label for="date">Dia e horário para ser exibido</label><br>
                <input type="date" name="date">
                <input type="time" name="time" step="1">
            </div><br>
                        <br>
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
    </div>
    </div>
</div>

<h2 style="text-align: center;
            margin-top: 20px;
            color: white;">SESSÕES DISPONÍVEIS</h2>

<div style="text-align: center;
            margin: 100px;
            margin-top: 40px;">
                
    <table class="table table-dark">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Data</th>
        <th scope="col">Horário</th>
        <th scope="col">Duração</th>
        <th scope="col">Filme</th>
        <th scope="col">Sala</th>
        <th scope="row">Opções</th>
        </tr>
    </thead>

    @foreach($sessions as $session)
        <tbody>
            <tr>
            <th scope="row">{{ $session->id }}</th>
            <td>{{ $session->date }}</td>
            <td>{{ $session->time }}</td>
            <td>{{ $session->movieDuration }}</td>
            <td>{{ $session->movieName }}</td>
            <td>{{ $session->roomName }}</td>
            <td>
                <a href="{{ route('updateSessionPage', $session->id) }}"><button type="button" class="btn btn-outline-warning">Atualizar</button></a>

                <form action="{{ route('destroySession', $session->id) }}" method="POST" style="display: inline-block;">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Apagar</button>
                </form>
           </td>

            </tr>
        </tbody>
    @endforeach
    </table>

</div>


<h2 style="text-align: center;
            margin-top: 20px;
            color: white;">FILMES DISPONÍVEIS</h2>

<div style="text-align: center;
            margin: 100px;
            margin-top: 40px;">
                
    <table class="table table-dark">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Nome</th>
        <th scope="row">Opções</th>
        </tr>
    </thead>

    @foreach($movies as $movie)
        <tbody>
            <tr>
            <th scope="row">{{ $movie->id }}</th>
            <td>{{ $movie->name }}</td>
            <td>
                <a href="{{ route('updateMoviePage', $movie->id) }}"><button type="button" class="btn btn-outline-warning" style="display: inline-block;">Atualizar</button></a>
                <form action="{{ route('destroyMovie',$movie->id) }}" method="POST" style="display: inline-block;">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Apagar</button>
                </form>
           </td>

            </tr>
        </tbody>
    @endforeach
    </table>

</div>


<h2 style="text-align: center;
            margin-top: 20px;
            color: white;">SALAS DISPONÍVEIS</h2>

<div style="text-align: center;
            margin: 100px;
            margin-top: 40px;">
                
    <table class="table table-dark">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Sala</th>
        <th scope="col">Opções</th>
        </tr>
    </thead>

    @foreach($rooms as $room)
        <tbody>
            <tr>
            <th scope="row">{{ $room->id }}</th>
            <td>{{ $room->name }}</td>
            <td>
                <form action="{{ route('destroyRoom',$room->id) }}" method="POST" style="display: inline-block;">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Apagar</button>
                </form>
           </td>

            </tr>
        </tbody>
    @endforeach
    </table>

</div>

@endsection

    
</body>
</html>