<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Session as ModelsSession;
use DateTime;
use DateTimeZone;

class Home extends Controller
{   
    /**
     * Retorna a página principal HOME do sistema
     *
     * @return void
     */
    public function index()
    {   
        //busca os filmes no banco de dados
        $movies = Movie::get();

        //retorna para a view inicial com os filmes encontrados
        return view('homepage', [
            'movies' => $movies
        ]);
    }

    /**
     * Busca todas as sessões com filmes e salas vinculados
     *
     * @return array
     */
    public function getSessions()
    {
        //busca todos as sessões que contêm filmes e salas vinculadas a mesma
        $session = ModelsSession::join('rooms', 'room_id', '=', 'rooms.id')
        ->join('movies', 'movie_id', '=', 'movies.id')
        ->select('date','time','movies.name','movies.description','movies.image','movies.id')
        ->get();

        //separa os atributos a serem utilizados em um array
        $sessions = $session->map(function($session){
        return collect($session->toArray())
        ->only(['date', 'time', 'name', 'description', 'image', 'id'])
        ->all();
        });

        return $sessions;
    }

    /**
     * Filtra as sessões que foram exibidas/cadastradas nos ultimos 10 dias
     *
     * @return void
     */
    public function lastMovies()
    {
        $sessions = $this->getSessions();

        //armazena a data atual
        $actualDate = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        //armazena a data de 10 dias atrás
        $tenDaysLeft = date('Y-m-d H:i:s',strtotime('-10 days', $actualDate->getTimestamp()));

        //cria um array de filmes
        $movies = array();

        //busca os filmes em que existem sessões entre os ultimos 10 dias até o dia atual
        foreach ($sessions as $session)
        {
            $sessionDate = date($session['date'] .' '.$session['time']);
            if ($sessionDate >= $tenDaysLeft && $sessionDate <= $actualDate->format('Y-m-d H:i:s')) {
                array_push($movies, $session);
            }
        }
        
        //retorna para a view homepage com o array de filmes dos ultimos 10 dias
        return view('homepage', [
            'movies' => $movies
        ]);
    }

    /**
     * Busca as sessões e filtra as que possuem uma data cadastrada para os próximos 5 dias.
     *
     * @return void
     */
    public function nextMovies()
    {   

        $sessions = $this->getSessions();

        //armazena a data atual
        $actualDate = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        //armazena a data de 5 dias à frente
        $fiveDayMore = date('Y-m-d H:i:s',strtotime('+5 days', $actualDate->getTimestamp()));

        //cria um array de filmes
        $movies = array();

        //busca os filmes em que a existem sessões cadadstradas para os próximos 5 dias
        foreach($sessions as $session)
        {
            $sessionDate = date($session['date'] .' '.$session['time']);
            if ($sessionDate <= $fiveDayMore && $sessionDate >= $actualDate->format('Y-m-d H:i:s')) {
                array_push($movies, $session);
            }
        }

        //retorna para a view principal com o array de filmes dos próxims 5 dias
        return view('homepage', [
            'movies' => $movies
        ]);
    }
}
