<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;


class CineClosedValidationService
{
    /**
     * Verifica se o cinema estará fechado no horário da sessão a ser adicionada
     *
     * @param Request $req
     * @return Boolea
     */
    public static function isCineClosed(Request $req): bool
    {
     
        $firstSessionTime = new DateTime($req->date .'10am', new DateTimeZone('America/Sao_Paulo'));

        $lastSessionTime = new DateTime($req->date . '11pm', new DateTimeZone('America/Sao_Paulo'));

        $session = new DateTime($req->date . $req->time, new DateTimeZone('America/Sao_Paulo'));

        if ($session < $firstSessionTime) {
            
            return true;
        }
        
        if ($session > $lastSessionTime) {
            
            return true;
        } 

        return false;
    }
}