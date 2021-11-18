<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="app/view/style/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="app/view/style/login.css">
    <link rel="shurtcut icon" type="image/png" href="public/img/login.png"/>
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Seu Login</h3>
                    <h3 class="title has-text-grey"><a href="" target="_blank">Estacionamento Tiburcio</a></h3>
                    <?php
                    if(isset($_COOKIE['nao_autenticado'])):
                    ?>
                    <div class="notification is-danger">
                      <p>ERRO: Usuário ou senha inválidos.</p>
                    </div>
                    <?php
                    endif;
                    unset($_COOKIE['nao_autenticado']);
                    ?>
                    <?php
                    if(isset($_COOKIE['cad_realizado'])):
                    ?>
                    <div class="notification is-success">
                      <p>Alteração realizada com sucesso.</p>
                    </div>
                    <?php
                    endif;
                    unset($_COOKIE['cad_realizado']);
                    ?>
                    <div class="box">
                        <form action="login" method="POST" id="user">
                            <div class="field">
                                <div class="control">
                                    <input name="usuario" class="input is-large user" placeholder="Seu usuário" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <input type="hidden" name="pass" value="autentico">
                            <button type="submit" id="user-submt" class="button is-block is-link is-large is-fullwidth">Entrar</button>
                            <a href="#" name="alter" class="button text-center">Esquei a senha</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="public/js/script-login.js" type="text/javascript"></script>
</body>
</html>