<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();
    if($token->checkAuth()){}else{header("Location: index.php");}
?>
<!DOCTYPE html>
<html>
    
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
                    <h3 class="title has-text-grey">Alterar senha</h3>
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
                    if(isset($_COOKIE['small_password'])):
                    ?>
                    <div class="notification is-danger">
                      <p>ERRO: Senha muito curta! Min 8 Caracteres não sequenciais</p>
                    </div>
                    <?php
                    endif;
                    unset($_COOKIE['small_password']);
                    ?>
                    <?php
                    if(isset($_COOKIE['nao_autentico'])):
                    ?>
                    <div class="notification is-danger">
                      <p>As senhas digitadas são diferentes</p>
                    </div>
                    <?php
                    endif;
                    unset($_COOKIE['nao_autentico']);
                    ?>
                    <div class="box">
                        <form action="alter-usuario" method="POST" id="form" onsubmit="return validation()">
                            <div class="field">
                                <div class="control">
                                    <input name="usuario" name="text" class="input is-large" placeholder="Seu usuário" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="senha1" class="input is-large" type="password" placeholder="Nova senha">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="senha2" class="input is-large" type="password" placeholder="Confirme a nova senha">
                                </div>
                            </div>
                            <input type="hidden" name="password" value="autenticado">
                            <input type="hidden" name="table" value="form-usuario">
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Alterar</button>
                            <a href="vagas" value="alter" class="button text-center">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="public/js/script.js" type="text/javascript"></script>
</body>
</html>