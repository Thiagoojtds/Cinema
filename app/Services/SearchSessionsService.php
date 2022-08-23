<?php

namespace App\Services;

use App\Models\Session;
use Illuminate\Database\Eloquent\Builder;


class SearchSessionsService
{
    public static function get(string $search)
    {
        $date = str_replace('/', '-', $search);
        $dateFormat = date('Y-m-d' , strtotime($date));

        return Session::whereHas('room', function (Builder $query) use($search){
            $query->where('name', 'LIKE', $search);
        })->orWhereHas('movie', function (Builder $query) use($search) {
            $query->where('name', 'LIKE', $search)
                    ->orWhere('duration', 'LIKE', $search);
        })->orWhere('id', 'LIKE', $search)
            ->orWhere('date', 'LIKE', $dateFormat)
            ->orWhere('sessions.time', 'LIKE', $search)
            ->orWhere('time', 'LIKE', $search)
            ->orWhere('endSession', 'LIKE', $search)
            ->orderBy('date')->orderBy('time')
            ->get();
    }
}