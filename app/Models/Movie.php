<?php

namespace App\Models;

use App\Services\ClassificationVerifyService;
use App\Services\MovieVerifyService;
use App\Services\TagsVerifyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'image',
        'classification',
    ];

    public function classification()
    {
        return $this->hasOne(Classification::class, 'id', 'classification');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public static function getSearchMovies(string $search)
    {
        $movies = Movie::with('tags')->get();
        
        $searchedMovies = array();

        foreach ($movies as $movie) {

            if (str_contains(Str::lower($movie->name), Str::lower($search))) {

                array_push($searchedMovies, $movie);
            }

            foreach ($movie->tags->pluck('name') as $movieTag) {

                if(Str::lower($movieTag) == Str::lower($search)) {

                    array_push($searchedMovies, $movie);
                }
            }
        }

        return collect($searchedMovies);
    }


    public static function getMovie($id)
    {
        return Movie::where('id', $id)->with('classification', 'tags')->get();
    }

    public static function createMovie(Request $movie)
    {   
        $movie->validate(MovieVerifyService::fields());

        $classification = ClassificationVerifyService::checkIfExistsAndReturnId($movie->classification);
    
        $tags = TagsVerifyService::checkIfExistsAndReturnId($movie->tags);

        try {

           $movie = Movie::create([
                'name' => $movie->name,
                'description' => $movie->description,
                'duration' => $movie->duration,
                'image' => $movie->image,
                'classification' => $classification,
           ]);

           $movie->tags()->attach($tags);
           
        } catch (\PDOException $e) {

            return back()->withErrors($e->getMessage());
        }
    }

    public static function updateMovie(int $id, Request $req)
    {
        $movie = $req->validate(MovieVerifyService::fields());
           
        $movie = Movie::findOrFail($id);

        $tags = TagsVerifyService::checkIfExistsAndReturnId($req->tags);

        $classification = ClassificationVerifyService::checkIfExistsAndReturnId($req->classification);

        try {

            $movie->update([
                'name' => $req->name,
                'duration' => $req->duration,
                'description' => $req->description,
                'image'=> $req->image,
                'classification' => $classification
            ]);
            
            $movie->tags()->delete();
            $movie->tags()->attach($tags);
                        
        } catch(\PDOException $e) {

            return back()->withErrors($e->getMessage());
        }
    }

    public static function deleteMovie(int $id)
    {
        $movie = Movie::findOrFail($id);
        
        if (!$movie->sessions()->get()->isEmpty()) {

            return back()->withErrors(['Filme vinculado à uma sessão']);
        }

        try {

            $movie->delete();

        } catch (\PDOException $e) {
            
            return back()->withErrors($e->getMessage());
        }
    }

}
