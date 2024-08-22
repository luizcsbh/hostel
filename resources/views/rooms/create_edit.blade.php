@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($room) ? 'Editar Quarto' : 'Novo Quarto' }}</h1>
    <form action="{{ isset($room) ? route('rooms.update', $room->id) : route('rooms.store') }}" method="POST">
        @csrf
        @if(isset($room))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="type_room_id">Tipo de Quarto:</label>
            <select name="type_of_room_id" id="type_of_room_id" class="form-control" required>
                <option value="">-- Selecione Tipo de Quarto --</option>
                @foreach($typeOfRooms as $typeOfRoom)
                    <option value="{{ $typeOfRoom->id }}" {{ ($room->type_of_room_id ?? old('type_of_room_id')) == $typeOfRoom->id ? 'selected' : '' }}>
                        {{ $typeOfRoom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantidade de ocupantes:</label>
            <input type="number" name="quantity" id="quantity" min="1" class="form-control" value="{{ $room->quantity ?? old('quantity') }}" required>
        </div>

        <div class="form-group">
            <label for="number_of_beds">N&uacute;mero de Camas:</label>
            <input type="number" name="number_of_beds" id="number_of_beds" min="1" class="form-control" value="{{ $room->number_of_beds ?? old('number_of_beds') }}" required>
        </div>

        <div class="form-group">
            <label for="daily_id">Di&aacute;ria:</label>
            <select name="daily_id" id="daily_id" class="form-control" required>
                <option value="">-- Selecione a Diária --</option>    
                @foreach($dailies as $daily)
                    <option value="{{ $daily->id }}" {{ ($room->daily_id  ?? old('daily_id')) == $daily->id ? 'selected' : '' }}>
                        {{ $daily->price }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Descri&ccedil;&atilde;o:</label>
            <textarea name="description" id="description" class="form-control" required>{{ $room->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="available">Dispon&iacute;vel:</label>
            <select name="available" id="available" class="form-control" required>
                <option value="1" {{ isset($room) && $room->available ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ isset($room) && !$room->available ? 'selected' : '' }}>N&atilde;o</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">{{ isset($room) ? 'Atualizar' : 'Criar' }}</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
