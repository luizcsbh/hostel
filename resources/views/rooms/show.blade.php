@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Quarto</h1>

    <div class="card mt-4">
        <div class="card-header">
            Quarto #{{ $room->id }}
        </div>
        <div class="card-body">
            <p><strong>Tipo de Quarto:</strong> {{ $room->typeOfRoom->name }}</p>
            <p><strong>Quantidade:</strong> {{ $room->quantity }}</p>
            <p><strong>N&uacute;mero de Camas:</strong> {{ $room->number_of_beds }}</p>
            <p><strong>Di&aacute;ria:</strong> R$ {{ $room->daily->price }}</p>
            <p><strong>Descri&ccedil;&atilde;o:</strong> {{ $room->description }}</p>
            <p><strong>Dispon&iacute;vel:</strong> {{ $room->available ? 'Sim' : 'Não' }}</p>
        </div>
        <div class="card-footer">
           <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Voltar</a>
           <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">Editar</a>
           <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
           </form>
        </div>
    </div>
</div>
@endsection
