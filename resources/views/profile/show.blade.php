@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
            <th>Telefone:</th>
            <td>{{ $user->cellphone }}</td>
        </tr>
        <tr>
            <th>Data de Nascimento:</th>
            <td>{{ $user->birth === null ? '': $user->birth->format('d/m/Y') }}</td>
        </tr>
    </table>

    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
</div>
@endsection
