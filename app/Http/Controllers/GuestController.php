<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::with('documentType')->get();
        return view('guest.index', compact('guests'));
    }

    public function create()
    {
        $documentTypes = DocumentType::all();
        return view('guest.create_edit', compact('documentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cellphone' => 'required|string|max:15',
            'birth' => 'required|date',
        ]);

        try {
            Guest::create($request->all());
            Session::flash('success', 'Hospede cadastrado com sucesso!');
        } catch (\Exception $e) {
            Session::flash('error', 'Erro ao cadastrar hóspede. Por favor, tente novamente.');
        }
       
        return redirect()->route('guests.index');
    }

    public function show(Guest $guest)
    {
        return view('guest.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        $documentTypes = DocumentType::all();
        return view('guest.create_edit', compact('guest', 'documentTypes'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cellphone' => 'required|string|max:15',
            'birth' => 'required|date',
        ]);

        try{
            $guest->update($request->all());
            Session::flash('success', 'Hóspede atualizado com sucesso!');
        } catch(\Exception $e){
            Session::flash('error', 'Erro ao atualizar hóspede. Por favor, tente novamente.');
        }
        return redirect()->route('guests.index');
    }

    public function destroy(Guest $guest)
    {
        try {
            $guest->delete();
            Session::flash('success', 'Hospede excluido com sucesso!');
        } catch (\Exception $e) {
            Session::flash('error', 'Erro ao excluir hospede. Por favor, tente novamente.');
        }

        return redirect()->route('guests.index');
    }
}
