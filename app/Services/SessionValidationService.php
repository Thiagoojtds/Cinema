<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Session;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class SessionValidationService
{   
    /**
     * Verifica se todas as validações estão sendo cumpridas
     *
     * @param Request $req
     * @return Boleean
     */
    public static function valid(Request $req)
    {
        if (CineClosedValidationService::isCineClosed($req)) {
            
            back()->withErrors('Cinema fechado');
            return false;
        }

        if (SessionValidationService::sameSession($req)) {
            
            back()->withErrors('Sessão já adicionada');
            return false;
        }

        if (PastDateValidationService::pastDate($req)) {
            
            back()->withErrors('Data inválida');
            return false;
        }  

        if (RoomValidationService::roomInSession($req)) {
            
            back()->withErrors('Sala estará em sessão');
            return false;
        }

        if (SessionValidationService::hasNextSessionStart($req)) {
            
            back()->withErrors('Sala ainda estará em sessão');
            return false;
        }

        if(RoomValidationService::roomInCleaning($req)) {
            
            back()->withErrors('Sala estará em limpeza');
            return false;
        }

        return true;
    }

    /**
     * Valida se a sessão a ser adicionada já existe, na mesma sala, data, hora e filme
     *
     * @param Request $req
     * @return Boolean
     */
    public static function sameSession(Request $req)
    {
        $sessionToAdd = $req;

        $sessions= Session::getSessionsWithMovies();

        foreach ($sessions as $session) {

            if($session->room->name == $sessionToAdd->room_id
            && $session->movie->name ==  $sessionToAdd->movie_id) {
                
                //se for na mesma data e horário, sala estara em sessão
                if ($session->date == $sessionToAdd->date && $session->time == $sessionToAdd->time) {
                    
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Valida se o filme a ser adicionado acaba depois do inicio da próxima sessão
     *
     * @param Request $req
     * @return Boolean
     */
    public static function hasNextSessionStart(Request $req)
    {
        $sessions = Session::getSessionsWithMovies();

        $movieToAdd = Movie::where('name', $req->movie_id)
                            ->select('duration')
                            ->get();

        $movieDurationSessionToAdd = MoviesDurationInSecondsService::get($movieToAdd->implode('duration'));

        foreach ($sessions as $key => $session) {
            
            if ($session->room->name == $req->room_id) {

                $nextSessionKey = $key+1;

                if ($nextSessionKey == sizeOf($sessions)) continue;

                $sessionToAddDateTime = new DateTime($req->date . $req->time, new DateTimeZone('America/Sao_Paulo'));

                $nextSessionDateTime = new DateTime($sessions[$nextSessionKey]['date'] . $sessions[$nextSessionKey]['time'],new DateTimeZone('America/Sao_Paulo'));

                $sessionToAddEndAt = new DateTime('America/Sao_Paulo');
                $sessionToAddEndAt->setTimestamp($sessionToAddDateTime->getTimestamp() + $movieDurationSessionToAdd);
                
                $nextSessionEndAt = new DateTime($sessions[$nextSessionKey]['date'] . $sessions[$nextSessionKey]['endSession'] ,new DateTimeZone('America/Sao_Paulo'));

                if ($sessionToAddEndAt > $nextSessionDateTime && $sessionToAddEndAt < $nextSessionEndAt) {
                    
                    return true;
                }
            }
        }
    }
}
