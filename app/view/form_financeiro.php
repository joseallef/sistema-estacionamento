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
	<?php
		require_once "menu.php";	
	?>
	<?php if(!isset($_GET['valor'])){ ?>
	<div class="containe">
    <form action="cadastrar-financeiro" method="POST" enctype="multipart/form-data" class="form p-4">
        <div class="m-5 p-5 text text-center">
            <label for="">Valor a ser pago em R$</label><br>
                <input type="text" name="valor" id="valor" maxlength="6" required="" class="m-2 tam" size="6" placeholder="120.00"><br>          
            <label for="">Seleione a data de vencimento:</label><br>
            <select name="vencimento" id="" required>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="5">5</option>
								<option value="8">8</option>
                <option value="10">10</option>
                <option value="16">16</option>
                <option value="21">21</option>
                <option value="26">26</option>
                <option value="30">30</option>
            </select>
            <textarea class="form-control" id="assunto" name="assunto" cols="0" rows="3" required placeholder="Assunto...(Informações)"></textarea>
            <input type="hidden" name="id_veiculo" value="<?php echo $_GET['v']; ?>">
            <input type="hidden" name="tabela" value="form_financeiro">
            <input type="submit" class="btn btn-primary" value="Cadastrar">
        </div>
	</form>
	</div>
	<?php
		}else if($_GET['valor'] == "cadSuccess"){
    ?>
	<div class="modal fade" id="cadSuccess" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="cadSuccess" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
				</div>
				<div class="modal-body">
					<div class="text text-center">
						<h3>Cadastro realizado com sucesso!</h3>
					</div>
				</div>
					<div class="modal-footer">
						<a href="veiculos" class="btn btn-primary">Fechar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php 
		} 
		require_once "../../lib/dep-script.php";
	?>	
</body>
</html>