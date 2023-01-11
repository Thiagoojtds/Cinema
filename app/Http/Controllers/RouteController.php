<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Movie;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tag;

class RouteController extends Controller
{

    public function description(int $id)
    {
        $sessions = Session::getSessionsByMovieId($id);
        $movie = Movie::getMovie($id)->toArray();

        return view('description', [
            'movie' => $movie,
            'sessions' => $sessions
        ]);
    }

    public function adminAuth()
    {   
        return view('login.login');
    }

    public function adminPage()
    {
        $movies = Movie::get();
        $sessions = Session::getSessionsWithMovies();
        $tags = Tag::get();
        $rooms = Room::get();
        $classification = Classification::get();


        return view('auth.adminPage', [
            'movies' => $movies,
            'tags' => $tags,
            'rooms' => $rooms,
            'classifications' => $classification,
            'sessions' => $sessions
        ]);
    }

    public function search(Request $req)
    {
        $searchedMovies = Movie::getSearchMovies($req->search);

        return view('homepage', [
            'movies' => $searchedMovies
        ]);
    }

    public function favicon()
    {
        return resource_path('/img');
    }
}
