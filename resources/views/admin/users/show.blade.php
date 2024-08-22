@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Usu&aacute;rio</h1>

    <table class="table">
        <tr>
            <th>Nome:</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Celular:</th>
            <td>{{ $user->cellphone }}</td>
        </tr>
        <tr>
            <th>Data de Nascimento:</th>
            <td>{{ $user->birth ? $user->birth->format('d/m/Y') : '' }}</td>
        </tr>
        <tr>
            <th>Papel:</th>
            <td>{{ ucfirst($user->role) }}</td>
        </tr>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este usuário?')">Deletar</button>
    </form>
</div>
@endsection
