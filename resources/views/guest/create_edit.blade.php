@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($guest) ? 'Editar Hóspede' : 'Novo Hóspede' }}</h1>

    <form action="{{ isset($guest) ? route('guests.update', $guest->id) : route('guests.store') }}" method="POST">
        @csrf
        @if(isset($guest))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $guest->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="document_type_id">Tipo de Documento:</label>
                    <select name="document_type_id" id="document_type_id" class="form-control" required>
                        <option value="">Selecione tipo de documento</option>
                        @foreach($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}" {{ isset($guest) && $guest->document_type_id == $documentType->id ? 'selected' : '' }}>
                                {{ $documentType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="document_number">N&uacute;mero do Documento:</label>
                    <input type="text" name="document_number" id="document_number" class="form-control" value="{{ $guest->document_number ?? old('document_number') }}" required>
                </div>
            </div>
            
        </div>

       

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $guest->email ?? old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="cellphone">Telefone:</label>
            <input type="text" name="cellphone" id="cellphone" class="form-control" value="{{ $guest->cellphone ?? old('cellphone') }}">
        </div>

        <div class="form-group">
            <label for="birth">Data de Nascimento:</label>
            <input type="date" name="birth" id="birth" class="form-control" value="{{ isset($guest) ? $guest->birth : old('birth') }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">{{ isset($guest) ? 'Atualizar' : 'Criar' }}</button>
        <a href="{{ route('guests.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
