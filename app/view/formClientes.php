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
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="nome" id="nome" maxlength="50" required="" class="place" size="50" placeholder="Digite o nome">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="E-mail" name="email" id="email" maxlength="50" required="" size="50" placeholder="E-mail">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-5">
					<input type="date" name="data" id="data" maxlength="10" required="" size="50" placeholder="Data de Nascimento">
				</div>		
				<div class="col-md-6 col-sm-12 col-xs-7">
					<input type="text" name="cpf" id="cpf" cpf-cnpj maxlength="14" size="14" required placeholder="Cpf">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-12">
					<select name="sexo" id="sexo" required>
						<option value="">Sexo</option>
						<option value="M">Masculino</option>
						<option value="F">Feminino</option>
					</select>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
					<select name="estC" id="estC" required>
						<option value="">Estado Civil</option>
						<option value="SO">Solteiro (a)</option>
						<option value="CA">Casado (a)</option>
					</select>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">		
					<input type="text" name="cep" id="cep" onkeypress="this.value = formCep(event)" required="" maxlength="9" size="9" placeholder="Cep">
				</div>
				<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
					<a href="#" class="btn btn-primary pesquisar">Buscar</a>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<a href="http://www.buscacep.correios.com.br/" target="_blank" class="btn btn-primary">Não sei o Cep</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<input type="text" name="estado" id="estado" maxlength="25" size="25" readonly="" placeholder="Estado">
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<input type="text" name="cid" id="cid" maxlength="50" size="50" readonly="" placeholder="Cidade">
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<input type="text" name="bairro" id="bairro" maxlength="50" size="50" readonly="" placeholder="Bairro">
				</div>			
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="rua" id="rua" maxlength="30" size="30" class="place" readonly="" placeholder="Rua">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-12 col-xs-12">
					<input type="text" name="numero" id="numero" maxlength="5" required="" size="5" placeholder="Número">
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12">
					<input type="text" name="com" id="com" maxlength="15" size="15" placeholder="Complemento">	
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12">
					<input type="text" name="telC" id="telC" required="" maxlength="15" size="15" placeholder="Telefone Celular">
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12">
					<input type="text" name="telF" id="telF" maxlength="14" size="14" placeholder="Telefone fixo">
				</div>				
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="file" name="arquivo" class="ar" id="arquivo" required>
				</div>
			</div>
				<input type="hidden" name="tabela" value="formClientes">
				<div class="text text-right">
					<button type="submit" class="btn btn-primary mr-0" >Cadastrar</button>
				</div>
			</div>	
		</form>
		<div class="spinner">
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