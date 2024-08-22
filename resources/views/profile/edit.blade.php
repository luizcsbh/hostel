@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Perfil</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="cellphone">Telefone:</label>
            <input type="text" name="cellphone" id="cellphone" class="form-control" value="{{ old('cellphone', $user->cellphone) }}" required>
        </div>

        <div class="form-group">
            <label for="birth">Data de Nascimento:</label>
            <input type="date" name="birth" id="birth" class="form-control" value="{{ old('birth', $user->birth === null ? '': $user->birth->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Altera&ccedil;&otilde;es</button>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
