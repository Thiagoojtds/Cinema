<?php

namespace App\Models;

use App\Services\RoomValidationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public static function createRoom(Request $room)
    {
        $data = $room->validate([
            'name'=> ['required'],
        ]);

        if(RoomValidationService::roomAlreadyExists($room))
        {
            return back()->withErrors('Sala Já Cadastrada');
        }

        try {

            Room::create($data);

        } catch(\PDOException $e) {

            return back()->withErrors($e->getMessage());
        }  
    }

    public static function deleteRoom(int $id) {
        
        $room = Room::findOrFail($id);

        if (!$room->sessions()->get()->isEmpty()) {

            return back()->withErrors(['Sala vinculada à uma sessão']);
        }

        try {

            $room->delete();

        } catch (\PDOException $e) {

            return back()->withErrors($e->getMessage());
        }
    }

    public static function updateRoom(Request $req, int $id)
    {
        $room = Room::findOrFail($id);

        if (RoomValidationService::roomAlreadyExists($req)) {

            return back()->withErrors('Sala já adicionada');
        }

        try{

            $room->update([
                'name' => $req->name,
            ]);

        } catch(\PDOException $e) {

            return back()->withErrors($e->getMessage());
        }
    }
}
