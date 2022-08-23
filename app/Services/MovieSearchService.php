<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;

class MovieSearchService
{
    public static function lastSessions()
    {
        $actualDate = ActualDateService::get();

        $tenDaysLeft = date('Y-m-d',strtotime('-10 days', $actualDate->getTimestamp()));

        return Movie::whereHas('sessions', function (Builder $query) use($tenDaysLeft,$actualDate) {
            $query->where('date', '<', $actualDate, 'AND', 'date', '>', $tenDaysLeft);
        })
        ->get();

    }

    public static function nextSessions()
    {
        $actualDate = ActualDateService::get();

        $fiveDayMore = date('Y-m-d',strtotime('+5 days', $actualDate->getTimestamp()));

        return Movie::whereHas('sessions', function (Builder $query) use($fiveDayMore,$actualDate) {
            $query->where('date', '>', $actualDate, 'AND', 'date', '<', $fiveDayMore);
        })
        ->get();
    }
}