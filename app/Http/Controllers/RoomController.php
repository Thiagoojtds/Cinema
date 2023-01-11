<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function store(Request $req)
    {   
        Room::createRoom($req);

        return redirect('/admin');
    }

    public function destroy(int $id)
    {
        Room::deleteRoom($id);

        return redirect('/admin');
    }

    public function update(Request $req, int $id)
    {
        Room::updateRoom($req,$id);
        
        return redirect('/admin');
    }
}
