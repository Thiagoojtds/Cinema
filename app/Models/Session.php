<?php

namespace App\Models;

use App\Services\SessionEndService;
use App\Services\SessionValidationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'room_id',
        'date',
        'time',
        'endSession'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }


    public static function getSessionsByMovieId($id)
    {
        return Session::where('movie_id', $id)->with('room')->get();
    }
    
    public static function getSessionsWithMovies()
    {
        return Session::with('movie', 'room')
                        ->orderBy('date')->orderBy('time')
                        ->get();
    }

    public static function updateSession(int $id, Request $req)
    {
        $session = Session::find($id);

        $movies = Movie::where('name', $req->movie_id)->get();

        $rooms = Room::where('name', $req->room_id)->get();

        $endSession = SessionEndService::get($req, $movies);

        if (!SessionValidationService::valid($req)) {
            
            return back();
        }

        try{

            $session->update([
                'movie_id' => $movies->implode('id'),
                'room_id' => $rooms->implode('id'),
                'date' => $req->date,
                'time' => $req->time,
                'endSession' => $endSession
            ]);

        }catch (\PDOException) {

            return back()->withErrors(['Preencha todos os campos.']);
        }

    }

    public static function storeSession($session)
    {

        $movie = Movie::where('name', $session['movie_id'])->get();

        $room = Room::where('name', $session['room_id'])->get();

        $date = new DateTime($session->date, new DateTimeZone('America/Sao_Paulo'));

        $endSession = SessionEndService::get($session, $movie);

        if(!SessionValidationService::valid($session))
        {
            return back();
        }

        try {

            Session::create([
                'movie_id' => $movie->implode('id'),
                'room_id'=> $room->implode('id'),
                'date' => $date,
                'time' => $session->time,
                'endSession' => $endSession
            ]);

        } catch(\PDOException) {

            return back()->withErrors(['Preencha todos os campos']);
        }
    }


}
