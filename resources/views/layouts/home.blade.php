<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ferramenta do Motorista</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<noscript>
    <h1>Esse site não funcionará corretamente se você não tiver o JavaScript habilitado no seu navegador.</h1>
</noscript>
<nav>
    <div class="nav-wrapper blue-grey darken-1">
        <a href="#!" class="brand-logo center">Ferramenta do Motorista</a>
        <ul class="left hide-on-med-and-down">
            <li><a class="btncadastro" href="#">Cadastro</a></li>
            <li><a class="btnlogin" href="#">Entrar</a></li>
        </ul>
    </div>
</nav>
<div class="content">
    @yield('content')
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="materialize/js/materialize.min.js"></script>

<div class="scripts">
    @yield('scripts')
</div>
</body>
</html>
