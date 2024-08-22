<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Reserve;
use App\Models\TypeOfRoom;
use App\Models\Guest;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function index()
    {
        $checkIns = CheckIn::with('reserve', 'typeOfRoom', 'guest')->get();
        return view('check_ins.index', compact('checkIns'));
    }

    public function create()
    {
        $reserves = Reserve::all();
        $types = TypeOfRoom::all();
        $guests = Guest::all();
        return view('check_ins.create', compact('reserves', 'types', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'type_of_room_id' => 'required|exists:type_of_rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'data' => 'required|date',
        ]);

        CheckIn::create($request->all());
        return redirect()->route('check_ins.index');
    }

    public function show(CheckIn $checkIn)
    {
        return view('check_ins.show', compact('checkIn'));
    }

    public function edit(CheckIn $checkIn)
    {
        $reserves = Reserve::all();
        $types = TypeOfRoom::all();
        $guests = Guest::all();
        return view('check_ins.edit', compact('checkIn', 'reserves', 'types', 'guests'));
    }

    public function update(Request $request, CheckIn $checkIn)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'type_of_room_id' => 'required|exists:type_of_rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'data' => 'required|date',
        ]);

        $checkIn->update($request->all());
        return redirect()->route('check_ins.index');
    }

    public function destroy(CheckIn $checkIn)
    {
        $checkIn->delete();
        return redirect()->route('check_ins.index');
    }
}
