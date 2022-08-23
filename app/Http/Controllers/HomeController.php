<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieSearchService;

class HomeController extends Controller
{
    public function index()
    {   
        $movies = Movie::get();

        return view('homepage', [
            'movies' => $movies
        ]);
    }

    public function lastMovies()
    {
        $movies = MovieSearchService::lastSessions();

        return view('homepage', [
            'movies' => $movies
        ]);
    }

    public function nextMovies()
    {   
        $movies = MovieSearchService::nextSessions();
        
        return view('homepage', [
            'movies' => $movies
        ]);
    }
}
