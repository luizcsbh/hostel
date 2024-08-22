@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerenciamento de Usu&aacute;rios</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-primary">Criar Novo Usu&aacute;rio</a>

    <table id="example" class="table mt-4 table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data de Nascimento</th>
                <th>Papel</th>
                <th>A&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->cellphone }}</td>
                    <td>{{ $user->birth ? $user->birth->format('d/m/Y') : '' }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este usuário?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "responsive": true, // Ativa o layout responsivo
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/Portuguese-Brasil.json" // Tradução para PT-BR
        }
    });
});
</script>
