@extends('layouts.layout')

@section('content')

<legend style="color: white"><center><h2><b>Atualizar Filme</b></h2></center></legend><br>

<form class="well form-horizontal"style="margin-left: 550px; color: white"action="{{ route('updateMovie', $movie->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group" >
    <label class="col-md-4 control-label">Nome do Filme</label>  
        <div class="col-md-4 inputGroupContainer">
            <input name="name" class="form-control"type="text" value="{{ $movie->name }}">
        </div>
    </div>

    <!-- Text input-->

    <div class="form-group">
    <label class="col-md-4 control-label" >Duração</label> 
        <div class="col-md-4 inputGroupContainer">
            <input type="time" name="duration" id="Duration" step="1" value="{{ $movie->duration }}"></input>
        </div>
    </div>


    <div class="form-group">
    <label class="col-md-4 control-label">Descrição</label>  
        <div class="col-md-4 inputGroupContainer">
            <textarea class="form-control" minlength="52" id="MovieDescription" name="description" rows="6" cols="50">{{ $movie->description }}</textarea>
        </div>
    </div>

    <!-- Text input-->

    <div class="form-group">
    <label class="col-md-4 control-label" >Imagem</label> 
        <div class="col-md-4 inputGroupContainer">
            <input type="url" class="form-control" id="MovieImage" value="{{ $movie->image }}"name="image">
        </div>
    </div>

    <!-- Text input-->

    <div class="form-group">
        <label>Tags</label> <br>
        <input class="col-md-4 control-label" name="tags" type="text" list="tags">
            <datalist id="tags">
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}"></option>
                @endforeach
            </datalist>
    </div>


    <div class="form-group">
    <label>Classificação indicativa</label><br>
        <select class="col-md-4 control-label" name="classification">
            @foreach($classifications as $classification)
                <option>{{ $classification->name }}</option>
            @endforeach
        </select>
    </div><br>

        <a href="{{ route('adminPage') }}"class="btn btn-danger">VOLTAR</a>
        <button type="submit" class="btn btn-danger" style="margin-left: 100px;">SUBMIT </button>
</form>


@endsection