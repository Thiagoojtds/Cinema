<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SessionEndService
{
      /**
     * Calcula com base na duração do filme a ser adicionado o horário em que a sessão irá acabar
     *
     * @param Request $req
     * @param Collection $movie
     * @return Datetime
     */
    public static function get(Request $req, Collection $movie) 
    {
        $sessionTimeStamp = new DateTime($req->date . $req->time,new DateTimeZone('America/Sao_Paulo'));
        
        $endSession = new DateTime($req->date . $req->time,new DateTimeZone('America/Sao_Paulo'));
        
        $endSession->setTimestamp($sessionTimeStamp->getTimestamp() + MoviesDurationInSecondsService::get($movie->implode('duration')));

        return $endSession->format('H:i:s');
    }
}