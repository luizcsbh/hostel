<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::all();
        return view('document_types.index', compact('documentTypes'));
    }

    public function create()
    {
        return view('document_types.create_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DocumentType::create($request->all());
        return redirect()->route('document-types.index');
    }

    public function show(DocumentType $documentType)
    {
        return view('document_types.show', compact('documentType'));
    }

    public function edit(DocumentType $documentType)
    {
        return view('document_types.create_edit', compact('documentType'));
    }

    public function update(Request $request, DocumentType $documentType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $documentType->update($request->all());
        return redirect()->route('document-types.index');
    }

    public function destroy(DocumentType $documentType)
    {
        // Verifica se há alguma restrição de integridade que possa impedir a exclusão
        // Exemplo: Verifica se há quartos associadas a esta diária
        if ($documentType->guests()->exists()) {
            return redirect()->route('document-types.index')->with('error', 'Não é possível remover Tipo de Documento. Existem Hóspede(s) associadas a este Tipo de Documento.');
        }
    
        try {
            // Tenta excluir o registro
            $documentType->delete();
    
            // Redireciona com uma mensagem de sucesso
            return redirect()->route('document-types.index')->with('success', 'Tipo de Documento removida com sucesso!');
        } catch (\Exception $e) {
            // Captura e trata exceções possíveis
            return redirect()->route('document-types.index')->with('error', 'Falha ao remover o Tipo de Documento. Por favor, tente novamente.');
        }
        $documentType->delete();
        return redirect()->route('document-types.index');
    }
}
