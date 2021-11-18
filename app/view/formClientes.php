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
        require_once 'menu.php';
    ?>
	<?php if(!isset($_GET['valor'])){ ?>
	<div class="containe">
		<form action="incluir-alter" method="POST" enctype="multipart/form-data" onsubmit="return validation()" class="form" id="form">
			<div class="row">
				<div class="col-md-6">
					<input type="text" name="nome" id="nome" maxlength="50" required="" class="place" size="50" placeholder="Digite o nome">
				</div>
				<div class="col-md-6">
					<input type="E-mail" name="email" id="email" maxlength="50" required="" size="50" placeholder="E-mail">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<input type="text" name="cpf" id="cpf" cpf-cnpj maxlength="14" size="14" required placeholder="Cpf">
				</div>
				<div class="col-md-3">
					<input type="text" name="telC" id="telC" required="" maxlength="15" size="15" placeholder="Telefone Celular">
				</div>	
				<div class="col-md-3">		
					<input type="text" name="cep" id="cep" onkeypress="this.value = formCep(event)" required="" maxlength="9" size="9" placeholder="Cep">
				</div>
				<div class="text-center mt-1 col-md-3">
					<a href="http://www.buscacep.correios.com.br/" target="_blank" class="btn btn-info text-white">Não sei o Cep</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="estado" id="estado" maxlength="25" size="25" readonly="" placeholder="Estado" required>
				</div>
				<div class="col-md-4">
					<input type="text" name="cid" id="cid" maxlength="50" size="50" readonly="" placeholder="Cidade">
				</div>
				<div class="col-md-4">
					<input type="text" name="bairro" id="bairro" maxlength="50" size="50" readonly="" placeholder="Bairro">
				</div>			
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="text" name="rua" id="rua" maxlength="30" size="30" class="place" readonly="" placeholder="Rua">
				</div>
				<div class="col-md-3">
					<input type="text" name="numero" id="numero" maxlength="5" required="" size="5" placeholder="Número">
				</div>
				<div class="col-md-3">
					<input type="text" name="com" id="com" maxlength="15" size="15" placeholder="Complemento">	
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="file" name="arquivo" class="ar" id="arquivo">
				</div>
			</div>
				<input type="hidden" name="tabela" value="formClientes">
				<div class="text-right">
					<button type="submit" class="btn btn-primary mr-0" >Cadastrar</button>
				</div>	
		</form>
		<div class="spinner">
			<img src="public/img/spinner.gif" alt="Carregando...">
		</div>
	</div>
	<?php
		}else if($_GET['valor'] == "Error")
	{ ?>
	<div class="modal fade" id="cadSuccess" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="cadSuccess" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
				</div>
				<div class="modal-body">
					<div class="text text-center">
						<h3>Já exite um cadastro com o CPF/CNPF informado!</h3>
					</div>
				</div>
					<div class="modal-footer">
						<a href="novo-cliente" class="btn btn-primary">Fechar</a>
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