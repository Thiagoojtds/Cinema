@extends('layouts.layout')

@section('content')

<legend><center><h2><b>Atualizar Sessão</b></h2></center></legend><br>

<form class="well form-horizontal" action="{{ route('updateSession', $session->id) }}" method="post"  id="contact_form" style="margin-left: 550px;">
        @csrf
        @method('PUT')

    <div class="form-group" >
    <label class="col-md-4 control-label">Filme que sera exibido</label>  
        <div class="col-md-4 inputGroupContainer">
                <select class="form-control" name="movie_id">
                    @foreach($movies as $movie)
                        <option>{{ $movie->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <!-- Text input-->

    <div class="form-group">
    <label class="col-md-4 control-label">Sala que sera exibido</label> 
        <div class="col-md-4 inputGroupContainer">
            <select class="form-control" name="room_id">
                    @foreach($rooms as $room)
                        <option>{{ $room->name }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <!-- Text input-->

    <div class="form-group">
    <label class="col-md-4 control-label">Dia e horário para ser exibido</label>  
        <div class="col-md-4 inputGroupContainer">
                <input type="date" name="date">
                <input type="time" name="time" step="1">
        </div>
    </div><br>

    <a href="{{ route('adminPage') }}"class="btn btn-danger">VOLTAR</a>
    <button type="submit" class="btn btn-danger" style="margin-left: 100px;">SUBMIT </button>

</form>


@endsection