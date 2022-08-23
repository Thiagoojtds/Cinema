<?php

namespace App\Services;

class MoviesDurationInSecondsService
{
    /**
     * Calcula a duração do filme em segundos
     *
     * @param string $movieDuration
     * @return string
     */
    public static function get(string $movieDuration)
    {
        list($hours,$minutes,$seconds) = explode(':', $movieDuration);

        return $hours * 3600 + $minutes * 60 + $seconds;
    }
}