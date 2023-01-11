<?php

namespace App\Services;

use DateTime;
use DateTimeZone;

/**
 * Service para criação e retorno da hora e data atual
 * @return Datetime
 */
class ActualDateService {

    public static function get()
    {
        return new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    }
}