@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerenciar Quartos</h1>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">Novo Quarto</a>

    <table id="example" class="table mt-4 table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de Quarto</th>
                <th>Quantidade</th>
                <th>N&uacute;mero de Camas</th>
                <th>Di&aacute;ria</th>
                <th>Descri&ccedil;&atilde;o</th>
                <th>Dispon&iacute;vel</th>
                <th>A&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->typeOfRoom->name }}</td>
                    <td>{{ $room->quantity }}</td>
                    <td>{{ $room->number_of_beds }}</td>
                    <td>R$ {{ $room->daily->price }}</td>
                    <td>{{ $room->description }}</td>
                    <td>{{ $room->available ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

