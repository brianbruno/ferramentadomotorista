<!DOCTYPE html>
<html>
<head>
    <title>Ferramenta do motorista</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="https://ferramentadomotorista.cf/laravel/public/materialize/css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="{{ URL::asset('css/usuarios.css') }}" />
</head>
<body>

<nav>
    <div class="nav-wrapper brown darken-4">
        <a href="#" class="brand-logo">Painel de controle</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ route('usuarios.index') }}">Todos usuários</a></li>
        </ul>
    </div>
</nav>


<div class="container">
    @yield('content')
</div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://ferramentadomotorista.cf/laravel/public/materialize/js/materialize.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<div id="scripts">
    @yield('script')
</div>
</body>
</html>