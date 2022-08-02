<?php

namespace App\Http\Controllers;

use App\Models\Movie as ModelsMovie;
use App\Models\Session as ModelsSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class Route extends Controller
{
    /**
     * Busca o filme com o id recebido por parâmetro e retorna a view de descrição do filme.
     *
     * @param integer $id
     * @return void
     */
    public function description(int $id)
    {
        //busca um registro de filme com o id recebido por parâmetro
        $movie = ModelsMovie::find($id);

        //busca as sessões que estão vinculadas ao filme com id recebido por parâmetro
        $sessions = ModelsSession::where('movie_id', '=', $movie->id)
                                ->join('movies', 'sessions.movie_id', '=', 'movies.id')
                                ->join('rooms', 'room_id', '=', 'rooms.id')
                                ->select('sessions.date','sessions.time', 'rooms.name as roomName','movies.duration', 'movies.classification', 'movies.tags')
                                ->get();

        //retorna para a view de descrição com os filmes e sessões
        return view('description', [
            'movie' => $movie,
            'sessions' =>$sessions
        ]);
    }

    /**
     * Retorna a view para login de adm.
     *
     * @return void
     */
    public function adminAuth()
    {   
        //retorna a view de login
        return view('login.login');
    }

    /**
     * Retorna a view da página de adm.
     *
     * @return void
     */
    public function adminPage()
    {
        //retorna a view de página de administrador
        return view('auth.adminPage');
    }

    /**
     * Busca os filmes por tags, e nomes no banco conforme o valor recebido na requisição.
     *
     * @param Request $req
     * @return void
     */
    public function search(Request $req)
    {
        //valida o preenchimento do campo
        $search = $req->validate([
            'search'=> ['required'],
        ]);
        
        //armazena a string conteudo o conteúdo a ser buscado
        $search = $req->search;

        //pega todos os filmes cadastrados
        $movies = ModelsMovie::get();

        //cria um array de filmes
        $searchedMovies = array();

        //busca os filmes que contem tags, ou nome a string buscada
        foreach ($movies as $movie)
        {
            if (Str::contains($movie['name'], $search) || Str::contains($movie['tags'], $search)) {
               array_push( $searchedMovies, $movie);
            }
        }

        //retorna para a view principal somente com os filmes encontrados
        return view('homepage', [
            'movies' => $searchedMovies
        ]);
    }


}
