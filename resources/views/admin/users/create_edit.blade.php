@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($user) ? 'Editar Usuário' : 'Criar Novo Usuário' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif
        
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
        </div>
        @if (isset($user))
        <div class="form-group">
            <label for="password">Senha <span class="text-danger">(deixe em branco para n&atilde;o alterar):<span></label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        @endif
        <div class="form-group">
            <label for="password_confirmation">Confirme a Senha:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="cellphone">Telefone:</label>
            <input type="text" name="cellphone" id="cellphone" class="form-control" value="{{ old('cellphone', $user->cellphone ?? '') }}">
        </div>

        <div class="form-group">
            <label for="birth">Data de Nascimento:</label>
            <input type="date" name="birth" id="birth" class="form-control" value="{{ old('birth', isset($user) && $user->birth ? $user->birth->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label for="role">Papel:</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Selecione um perfil</option>
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="attendant" {{ old('role', $user->role ?? '') == 'attendant' ? 'selected' : '' }}>Atendente</option>
                <option value="guest" {{ old('role', $user->role ?? '') == 'guest' ? 'selected' : '' }}>H&oacute;spede</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($user) ? 'Atualizar' : 'Criar' }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
