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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
</head>
<body>
    <?php require_once "menu.php"; ?>
	<div class="containe">
    <form action="cliente-avulso" method="POST" enctype="multipart/form-data" class="form p-4">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label for="">Nome:</label>
                <input type="text" name="nome" id="nome" maxlength="50" required="" class="m-2" size="50" placeholder="Digite o nome">  
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12 col-sx-12">
                    <label for="">CPF ou RG:<br> </label>
                        <input type="text" name="rg_cpf" id="cpf" maxlength="14" size="14" class="tam m-3" placeholder="0.000.000-0 / 000.000.000-00">
                   
                </div>
                <div class="col-md-4 col-sm-12 col-sx-12">
                    <label for="">Telefone Celular:<br>
                        <input type="text" name="telC" id="telC" required="" maxlength="15" size="15" class="tam m-3" placeholder="(11) 00000-0000">
                    </label>
                </div>
                <div class="col-md-4 col-sm-12 col-sx-12">
                    <label for="">Placa:<br>
                        <input type="text" name="placa" id="placa" required="" maxlength="15" size="15" class="tam m-3" placeholder="AAA-0000">
                    </label>
                </div>          
            </div>          
            <input type="hidden" name="tabela" value="form_clientes_avulso">
            <input type="submit" class="btn btn-primary" value="Cadastrar">
        </div>
	</form>
	</div>
	<?php
        require_once "../../lib/dep-script.php";
	 ?>		
</body>
</html>