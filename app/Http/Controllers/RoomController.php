<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TypeOfRoom;
use App\Models\Daily;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
    public function __construct(Room $room)
    {
        $this->room = $room;
    }
    
    public function index()
    {
        return response()->json($this->room->with('typeOfRoom', 'daily')->paginate(5), 200);
    }

    public function create()
    {
        $typeOfRooms = TypeOfRoom::all();
        $dailies = Daily::all();
        return view('rooms.create_edit', compact('typeOfRooms', 'dailies'));
    }

    public function store(Request $request)
    {
        
        $request->validate($this->room->rules(), $this->room->feedback());

        $room = $this->room->create([
            'type_of_room_id' => $request->type_of_room_id, 
            'quantity' => $request->quantity,
            'number_of_beds' => $request->number_of_beds,
            'daily_id' => $request->daily_id,
            'description' => $request->description,
            'available'=> $request->available
        ]);

        return response()->json($room, 201);
    }

    public function show($id)
    {
        $room = $this->room->with('typeOfRoom', 'daily')->find($id);
        if($room === null) {
            return reponse()->json(['erro' => 'Quarto pesquisado não existe'], 404);
        }

        return response()->json($room, 200);
    }

    public function edit(Room $room)
    {
        $typeOfRooms = TypeOfRoom::all();
        $dailies = Daily::all();
        return view('rooms.create_edit', compact('room', 'typeOfRooms', 'dailies'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'type_of_room_id' => 'required|exists:type_of_rooms,id',
            'quantity' => 'required|integer',
            'number_of_beds' => 'required|integer',
            'daily_id' => 'required|exists:dailies,id',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
        ]);

        $room->update($request->all());
        return redirect()->route('rooms.index');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index');
    }
}
