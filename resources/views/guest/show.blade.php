@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Hóspede</h1>

    <div class="card mt-4">
        <div class="card-header">
            Hóspede #{{ $guest->id }}
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $guest->name }}</p>
            <p><strong>Tipo de documento:</strong> {{ $guest->documentType->name }}</p>
            <p><strong>Número do documento:</strong> {{ $guest->document_number }}</p>
            <p><strong>Email:</strong> {{ $guest->email }}</p>  
            <p><strong>Telefone:</strong> {{ $guest->cellphone }}</p> 
            <p><strong>Data de nascimento:</strong> {{ $guest->birth->format('d/m/Y') }}</p> 
            
        </div>
        <div class="card-footer">
            <a href="{{ route('guests.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
            </form>
        </div>
    </div>
</div>
@endsection
