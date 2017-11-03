@extends('layouts.home')

@section('content')
<div class="row">
    <div class="col s12 m6 l6">
        <div class="container">
            <h4>Com a Ferramenta você pode:</h4><br>
            <h5><i class="material-icons">account_box</i> Criar uma conta</h5>
            <h5><i class="material-icons">account_balance_wallet</i> Saber quanto você lucrou por dia</h5>
            <h5><i class="material-icons">trending_up</i> Melhorar seus lucros</h5>
            <h5><i class="material-icons">history</i> Anotar seus ganhos</h5>
            <h5><i class="material-icons">touch_app</i> Acessar de qualquer lugar</h5>
            <h5><i class="material-icons">money_off</i> Fazer tudo gratuitamente</h5><br>
            <center>
                <h4>Crie já sua conta</h4>
            </center>

        </div>
    </div>
    <div id="cadastro" class="col s12 m6 l6">
        <div class="container">
            <center>
                <div class="col s12 m6 l6">
                    <h2>Cadastro</h2>
                </div>
                <div class="col s12 m6 l6">
                    <h2><a class="waves-effect waves-light btn btn-large btnlogin light-green"><i class="material-icons right">assignment_ind</i>Login</a></h2>
                </div>
            </center>
            <form class="col s12" id="cadastro">
                <div class="row">
                    <div class="input-field col s6">
                        <input id="nome" type="text" class="validate" name="nome" required>
                        <label for="nome">Nome</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="sobrenome" type="text" class="validate" name="sobrenome" required>
                        <label for="sobrenome">Sobrenome</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email" required>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="senha" type="password" class="validate" name="senha" required>
                        <label for="password">Senha</label>
                    </div>
                </div>
                <center>
                    <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Cadastrar
                        <i class="material-icons right">send</i>
                    </button>
                </center>
            </form>
        </div>
    </div>

    <div id="login" class="col s12 m6 l6">
        <div class="container">
            <center>
                <div class="col s12 m6 l6">
                    <h2>Login</h2>
                </div>
                <div id="botaocadastro" class="col s12 m6 l6">
                    <h2><a class="waves-effect waves-light btn btn-large btncadastro light-green"><i class="material-icons right">assignment_ind</i>Cadastrar</a></h2>
                </div>
            </center>
            <form id="login" class="col s12" action="inc/login.php" method="post">

                <div class="row">
                    <div class="input-field col s12">
                        <input id="email_login" type="email" class="validate" name="email" required>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="senha_login" type="password" class="validate" name="senha" required>
                        <label for="password">Senha</label>
                    </div>
                </div>
                <center>
                    <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Entrar
                        <i class="material-icons right">send</i>
                    </button>
                </center>
            </form>
        </div>
    </div>

    <div id="carrega" class="col s12 m6 l6">
        <center>
            <br><br><br><br><br><br><br><br><br><br>
            <div class="progress">
                <div class="indeterminate light-green accent-3"></div>
            </div>
            <div id="mensagem"></div>
        </center>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        $("#login").hide();
        $("#carrega").hide();

        $(".btnlogin").click(function() {
            $("#cadastro").hide();
            $("#login").show();
        });
        $(".btncadastro").click(function() {
            $("#login").hide();
            $("#cadastro").show();
        });

        $("#cadastro").submit(function(e) {
            $("#cadastro").hide();
            $("#carrega").show();
            Materialize.toast("Aguarde, realizando seu cadastro", 4000, 'rounded');
            var url = "inc/cadastro.php"; // the script where you handle the form input.
            var $form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    nome: $('#nome').val(),
                    sobrenome: $('#sobrenome').val(),
                    email: $('#email').val(),
                    senha: $('#senha').val()
                }, // serializes the form's elements.
                success: function(data) {
                    Materialize.toast(data, 4000, 'rounded');
                    if (data == "Cliente cadastrado com sucesso!") {
                        $("#carrega").hide();
                        $("#login").show();
                        $("#botaocadastro").hide();
                        Materialize.toast("Realize seu login", 4000, 'rounded');
                    } else {
                        $("#carrega").hide();
                        $("#cadastro").show();
                        Materialize.toast("Tente novamente!", 4000, 'rounded');
                    }
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });

        $("#login").submit(function(e) {
            $("#login").hide();
            $("#carrega").show();
            Materialize.toast("Realizando seu login", 4000, 'rounded');
            var url = "auth/login.php"; // the script where you handle the form input.
            var $form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    email: $('#email_login').val(),
                    senha: $('#senha_login').val()
                }, // serializes the form's elements.
                success: function(data) {
                    Materialize.toast(data, 4000, 'rounded');
                    if (data == "Logado com sucesso.") {
                        $("#login").hide();
                        $("#carrega").show();
                        $("#mensagem").html("Clique <a href='/client'>aqui</a> caso você não seja redirecionado.");
                        $(location).attr('href', '/');
                        Materialize.toast("Você está sendo redirecionado, aguarde...", 4000, 'rounded');
                    } else {
                        $("#carrega").hide();
                        $("#login").show();
                    }
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });

    });
</script>

@endsection
