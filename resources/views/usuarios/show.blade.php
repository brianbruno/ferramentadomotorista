@extends('usuarios.layout.home')

@section('content')
    <div class="row">
        <div class="col l8">
            <h2>{{ $usuario[0]->nome }} {{ $usuario[0]->sobrenome }}</h2>
        </div>
        <div class="col l4">
            <a class="btn waves-effect waves-light orange darken-4" href="{{ route('usuarios.index') }}">Editar</a>
            <a class="btn waves-effect waves-light red darken-4" href="{{ route('usuarios.index') }}">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a class="active" href="#informacoes">Informações</a></li>
                <li class="tab col s4"><a href="#registros">Registros</a></li>
                <li class="tab col s4"><a href="#configuracoes">Configurações</a></li>
            </ul>
        </div>
        <div id="informacoes" class="col s12">
            <div class="row">
                <div class="col l12">
                    <h5>{{ $usuario[0]->email }}</h5>
                </div>
            </div>
        </div>
        <div id="registros" class="col s12">
            <div class="row">
                @if (!$registros->isEmpty())
                    <div class="row">
                        @php ($i = 0)
                        <div class="coll l12">
                            <h4>Ganhos por mês</h4>
                            <table class="table highlight bordered">
                                <tr>
                                    <th>Mês</th>
                                    <th>Total de ganhos (R$)</th>
                                    <th>Média (R$)</th>
                                </tr>
                                @foreach ($ganhosPorMes as $mes)
                                    <tr>
                                        <td>{{ $mesesDoAno[$i] }}</td>
                                        <td>{{ $mes[0]->ganhosMes }}</td>
                                        <td>{{ $mes[0]->mediaMes }}</td>
                                    </tr>
                                    @php ($i++)
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col l12">
                                <h5>Total de registros: {{ $usuario[0]->total_registros }}</h5>
                                <h5>Média por cada registro: {{ $usuario[0]->media_registros }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l12">
                                <table class="table highlight bordered">
                                    <tr>
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Valor (R$)</th>
                                    </tr>
                                    @foreach ($registros as $registro)
                                        <tr>
                                            <td>{{ $registro->id }}</td>
                                            <td>{{ $registro->data}}</td>
                                            <td>{{ $registro->valor}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col l12">
                        <h4>Usuário não possui nenhum registro cadastrado</h4>
                    </div>
                @endif
            </div>
        </div>
        <div id="configuracoes" class="col s12">Test 3</div>
    </div>

@endsection

@section('script')
    <script>
    $(document).ready(function(){
        $('ul.tabs').tabs('select_tab', 'informacoes');
    });
    </script>
@endsection