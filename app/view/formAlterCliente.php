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
	<title>Alterar Cadastro</title>
	<link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
</head>
<body>
	<?php
		require_once "menu.php";
		require_once "../controllers/Criptor.php";
		require_once "../controllers/Cliente.php";
		use AppC\Criptor;
		use AppC\Cliente;
		$criptor = new Criptor;
		$cliente = new Cliente;
		
	?>
	<div class="containe">	
		<form action="alter-cliente" method="POST" enctype="multipart/form-data" class="form" id="form">
			<?php
				foreach($cliente->listarTodosDadosCliente($criptor->base64($_GET['v'], 2)) as $reg){			
			?>
			<div class="row">
				<div class="col-md-6">
					<input type="text" name="nome" id="nome" value="<?php echo $reg['nome']; ?>" maxlength="50" required size="50" placeholder="Digite seu nome">
				</div>
				<div class="col-md-6">
					<input type="E-mail" name="email" id="email" value="<?php echo $reg['email']; ?>" maxlength="50" size="50" required placeholder="E-mail">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<input type="text" name="cpf" id="cpf" cpf-cnpj value="<?php echo $reg['cpf']; ?>" maxlength="18" size="18" required placeholder="Cpf">
				</div>
				<div class="col-md-3">
					<input type="text" name="telC" id="telC" value="<?php echo $reg['telmovel']; ?>" maxlength="15" size="15" required placeholder="Telefone Celular">
				</div>
				<div class="col-md-3">
					<input type="text" name="cep" id="cep" value="<?php echo $reg['cep']; ?>" onkeypress="this.value = formCep(event)" required maxlength="9" size="9" placeholder="Cep">
				</div>
				<div class="text-center mt-1 col-md-3">
					<a href="http://www.buscacep.correios.com.br/" target="_blank" class="btn btn-info">Não sei o CEP</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="estado" id="estado" value="<?php echo $reg['estado']; ?>" maxlength="25" size="25" readonly="" placeholder="Estado" required>
				</div>
				<div class="col-md-4">
					<input type="text" name="cid" id="cid" value="<?php echo $reg['cidade']; ?>"  maxlength="50" size="50" readonly="" placeholder="Cidade">
				</div>
				<div class="col-md-4">
					<input type="text" name="bairro" id="bairro" value="<?php echo $reg['bairro']; ?>" maxlength="50" size="50" readonly="" placeholder="Bairro">
				</div>			
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="text" name="rua" id="rua" value="<?php echo $reg['rua'];?>" maxlength="30" size="30" class="place" readonly="" placeholder="Rua">
				</div>
				<div class="col-md-3">
					<input type="text" name="numero" id="numero" value="<?php echo $reg['numero']; ?>" maxlength="5" required="" size="5" placeholder="Número">
				</div>
				<div class="col-md-3">
					<input type="text" name="com" id="com" value="<?php echo $reg['complemento']; ?>" maxlength="15" size="15" placeholder="Complemento">	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<input type="file" name="arquivo" id="arquivo" class="ar">
				</div>
			</div>
					<input type="hidden" name="arq" id="arq" value="<?php echo $reg['foto']; ?>">
					<input type="hidden" name="v" id="id_cep_alter" value="<?php echo $reg['id']; ?>">
					<input type="hidden" name="tabela" value="formAlterCliente">
				<div class="text-right">
					<button type="submit" class="btn btn-primary mr-0" >Alterar</button>
				</div>
			<?php
				}
			?>
		</form>
		<div class="spinner">
			<img src="public/img/spinner.gif" alt="Carregando...">
		</div>
	</div>
	<?php
		require_once "../../lib/dep-script.php";
	?>
</body>
</html>