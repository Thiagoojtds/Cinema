<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function store(Request $req)
    {   
        Movie::createMovie($req);

        return redirect('/');
    }


    public function destroy(int $id)
    {   
        Movie::deleteMovie($id);

        return redirect('/admin');
    }


    public function update(int $id, Request $req)
    {
        Movie::updateMovie($id, $req);

        return redirect('/admin');

    }

    public function updateMoviePage(int $id)
    {   
        $movie = Movie::findOrFail($id);
        $tags = Tag::get();
        $classification = Classification::get();

        return view('auth.updateMovie', [
            'movie' => $movie,
            'classifications' => $classification,
            'tags' => $tags
        ]);
    }
}
