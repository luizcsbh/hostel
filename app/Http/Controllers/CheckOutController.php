<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\Reserve;
use App\Models\TypeOfRoom;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function index()
    {
        $checkOuts = CheckOut::with('reserve', 'typeOfRoom')->get();
        return view('check_outs.index', compact('checkOuts'));
    }

    public function create()
    {
        $reserves = Reserve::all();
        $types = TypeOfRoom::all();
        return view('check_outs.create', compact('reserves', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'type_of_room_id' => 'required|exists:type_of_rooms,id',
            'data_saida' => 'required|date',
        ]);

        CheckOut::create($request->all());
        return redirect()->route('check_outs.index');
    }

    public function show(CheckOut $checkOut)
    {
        return view('check_outs.show', compact('checkOut'));
    }

    public function edit(CheckOut $checkOut)
    {
        $reserves = Reserve::all();
        $types = TypeOfRoom::all();
        return view('check_outs.edit', compact('checkOut', 'reserves', 'types'));
    }

    public function update(Request $request, CheckOut $checkOut)
    {
        $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'type_of_room_id' => 'required|exists:type_of_rooms,id',
            'data_saida' => 'required|date',
        ]);

        $checkOut->update($request->all());
        return redirect()->route('check_outs.index');
    }

    public function destroy(CheckOut $checkOut)
    {
        $checkOut->delete();
        return redirect()->route('check_outs.index');
    }
}
