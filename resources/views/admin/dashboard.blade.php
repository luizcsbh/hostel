@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Dashboard do Administrador</h1>
        <p class="lead">Bem-vindo, administrador! Aqui voc&ecirc; pode gerenciar todas as fun&ccedil;&otilde;es do sistema.</p>
        <hr class="my-4">
        <p>Utilize o menu de navega&ccedil;&atilde;o para acessar as diferentes funcionalidades administrativas.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('users.index') }}" role="button">Gerenciar Usu&aacute;rios</a>
        <a class="btn btn-primary btn-lg" href="{{ route('type-rooms.index') }}" role="button">Gerenciar Tipos de Quartos</a>
        <a class="btn btn-primary btn-lg" href="{{ route('dailies.index') }}" role="button">Gerenciar Pre&ccedil;o de Di&aacute;rias</a>
        <a class="btn btn-primary btn-lg" href="{{ route('rooms.index') }}" role="button">Gerenciar Quartos</a>
        <a class="btn btn-primary btn-lg" href="#" role="button">Relat&aacute;rios</a>
    </div>
</div>
@endsection
