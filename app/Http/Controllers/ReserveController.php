<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index()
    {
        $reserves = Reserve::with('room', 'guest')->get();
        return view('reserves.index', compact('reserves'));
    }

    public function create()
    {
        $rooms = Room::all();
        $guests = Guest::all();
        return view('reserves.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'data_entrada' => 'required|date',
            'data_saida' => 'required|date',
            'total_value' => 'required|numeric',
        ]);

        Reserve::create($request->all());
        return redirect()->route('reserves.index');
    }

    public function show(Reserve $reserve)
    {
        return view('reserves.show', compact('reserve'));
    }

    public function edit(Reserve $reserve)
    {
        $rooms = Room::all();
        $guests = Guest::all();
        return view('reserves.edit', compact('reserve', 'rooms', 'guests'));
    }

    public function update(Request $request, Reserve $reserve)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'data_entrada' => 'required|date',
            'data_saida' => 'required|date',
            'total_value' => 'required|numeric',
        ]);

        $reserve->update($request->all());
        return redirect()->route('reserves.index');
    }

    public function destroy(Reserve $reserve)
    {
        $reserve->delete();
        return redirect()->route('reserves.index');
    }
}
