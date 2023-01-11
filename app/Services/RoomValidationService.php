<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Session;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class RoomValidationService
{
    /**
     * Verifica se já existe uma sala cadastrada com o mesmo nome
     *
     * @param Request $req
     * @return Boolean
     */
    public static function roomAlreadyExists(Request $req)
    {
        $rooms = Room::get();

        //percorre o array com as salas cadastrada e verifica se os nomes são iguais
        foreach ($rooms as $room) {
            
            if (Str::lower($req->name) == Str::lower($room->name)) {
                
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica se a sala não está em sessão em sessão no momento em que uma nova vor adicionada/atualizada
     *
     * @param Request $sessionToAdd
     * @return Boolean
     */
    public static function roomInSession(Request $sessionToAdd)
    {
        $ordenedSessions = Session::getSessionsWithMovies();

        foreach ($ordenedSessions as $session) {
            
            if ($session->room->name == $sessionToAdd->room_id) {
                
                $sessionDateTime = new DateTime($session->date . $session->time, new DateTimeZone('America/Sao_Paulo'));

                $sessionEndAt = new DateTime($session->date . $session->endSession ,new DateTimeZone('America/Sao_Paulo'));

                $sessionToAddDateTime = new DateTime($sessionToAdd->date . $sessionToAdd->time, new DateTimeZone('America/Sao_Paulo'));

                if($sessionToAddDateTime > $sessionDateTime && $sessionToAddDateTime < $sessionEndAt) {
                    
                    return true;
                }
                
            }
        }
    }

    /**
     * Verifica se a sessão a ser adicionada não está entre o tempo de limpeza após cada sessão
     *
     * @param Request $req
     * @return Boolean
     */
    public static function roomInCleaning(Request $req)
    {
        $sessions = Session::getSessionsWithMovies();
                
        foreach ($sessions as $session) {

            if ($session->room->name == $req->room_id) {

                $sessionToAddDateTime = new DateTime($req->date . $req->time, new DateTimeZone('America/Sao_Paulo'));

                $sessionDateTime = new DateTime($session->date . $session->time, new DateTimeZone('America/Sao_Paulo'));

                $sessionEndAt = new DateTime($session->date . $session->endSession ,new DateTimeZone('America/Sao_Paulo'));

                $minutesAfter = new DateTime('America/Sao_Paulo');
                $minutesAfter->setTimestamp(strtotime('+30 minutes', $sessionEndAt->getTimestamp()));

                if ($sessionToAddDateTime > $sessionDateTime && $sessionToAddDateTime < $minutesAfter) {
                    
                    return true;
                }
            }
        }
    }
}