<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class PastDateValidationService
{
        /**
     * Valida se a data e hora da sessão a ser adicionada não é antes do dia e hora atual
     *
     * @param Request $req
     * @return Boolean
     */
    public static function pastDate(Request $req)
    {
        $sessionTime = new DateTime($req->date . $req->time, new DateTimeZone('America/Sao_Paulo'));
        
        $actualDate = ActualDateService::get();

        if ($sessionTime < $actualDate) {
            
            return true;
        }

        return false;
    }
}