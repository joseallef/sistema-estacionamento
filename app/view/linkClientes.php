<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();   
    if($token->checkAuth()){}else{header("Location: index.php");}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opcoes</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
</head>
<body>
    <?php
        require_once 'menu.php';
    ?>
<div class="containe">
<section>
    <div class="text text-center">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Avulso<br>
                <i class="fa fa-address-card fa-lg btn btn-primary"></i>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                Mensalista<br>
                <i class="fa fa-calendar fa-lg btn btn-primary"></i>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">Novo Avulso<br>
                <a href="novo-cliente-avulso" class="btn btn-success p-2"><i class="fa fa-user-plus"></i></a>                  
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">Clientes Avulso<br>           
                <a href="clientes-avulso" class="btn btn-secondary p-2"><i class="fa fa-users"></i></a>
            </div>
            <div class="col-md-2 div">|</div>
            <div class="col-md-2 col-sm-6 col-xs-12">Novo Mensalista<br>
                <a href="novo-cliente" class="btn btn-success p-2"><i class="fa fa-user-plus"></i></a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">Clientes Mensalista<br>            
                <a href="clientes" class="btn btn-secondary p-2"><i class="fa fa-users"></i></a>
            </div>
        </div>
    </div>
</section>
</div>
    <?php
		require_once "../../lib/dep-script.php";
	?> 
</body>
</html>
