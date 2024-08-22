@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerenciamento de H&oacute;spedes</h1>
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    
    <a href="{{ route('guests.create') }}" class="btn btn-primary">Novo H&oacute;spede</a>
    <table id="example" class="table mt-4 table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo de Documento</th>
                <th>N&uacute;mero do Documento</th>
                <th>Email</th>
                <th>Celular</th>
                <th>A&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $guest)
                <tr>
                    <td>{{ $guest->id }}</td>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->documentType->name }}</td>
                    <td>{{ $guest->document_number }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->cellphone }}</td>
                    <td>
                        <a href="{{ route('guests.show', $guest->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" style="display:inline;">
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
