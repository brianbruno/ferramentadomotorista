@extends('usuarios.layout.home')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Usuários cadastrados Ferramenta do Motorista</h4>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="responsive-table highlight">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Email</th>
        <th>Registros cadastrados</th>
        <th width="280px">Ações</th>
    </tr>
    @foreach ($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->id }}</td>
        <td>{{ $usuario->nome}}</td>
        <td>{{ $usuario->sobrenome}}</td>
        <td>{{ $usuario->email }}</td>
        <th><center>{{ $usuario->total_registros }}</center></th>
        <td>
            <a class="btn waves-effect waves-light teal darken-4" href="{{ route('usuarios.show',$usuario->id) }}">Mais informações</a>
        </td>
    </tr>
    @endforeach
</table>

@endsection