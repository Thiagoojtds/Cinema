<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Session;
use App\Models\Tag;
use App\Services\SearchSessionsService;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function store(Request $req)
    {
        Session::storeSession($req);

        return redirect('/admin');
    }

    public function update(int $id, Request $req)
    {   
        Session::updateSession($id, $req);

        return redirect('/admin');
    }

    public function destroy(int $id)
    {   
        $session = Session::findOrFail($id);

        $session->delete();
        
        return redirect('/admin');
    }

    public static function updateSessionPage(int $id)
    {
        $session = Session::findOrFail($id);
        $movies = Movie::get();
        $rooms = Room::get();

        return view('auth.updateSession', [
                    'session' => $session,
                    'movies' => $movies,
                    'rooms' => $rooms
        ]);
    }

    public function searchTable(Request $req)
    {
        $movies = Movie::get();
        $rooms = Room::get();
        $tags = Tag::get();
        $classification = Classification::get();

        $search = SearchSessionsService::get($req->search);

        return view('auth.adminPage', [
                    'movies' => $movies,
                    'tags' => $tags,
                    'rooms' => $rooms,
                    'classifications' => $classification,
                    'sessions' => $search
        ]);
    }
}

