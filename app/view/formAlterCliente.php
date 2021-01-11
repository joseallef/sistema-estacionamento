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
				<input type="text" name="nome" id="nome" value="<?php echo $reg['nome']; ?>" maxlength="50" required size="50" placeholder="Digite seu nome">
				<input type="E-mail" name="email" id="email" value="<?php echo $reg['email']; ?>" maxlength="50" size="50" required class="place" placeholder="E-mail">
				<input type="date" name="data" id="data" value="<?php echo $reg['data']; ?>" maxlength="10" size="50" required class="tam place" placeholder="Data de Nascimento">
				<input type="text" name="cpf" id="cpf" value="<?php echo $reg['cpf']; ?>" maxlength="18" size="18" required class="tam place" placeholder="Cpf">
				<div class="box">
					<select name="sexo" id="sexo" required>
						<?php if($reg['sexo'] == "M"){ ?>
							<option value="M" selected>Masculino</option>
							<option value="F" >Feminino</option>
						<?php } else {?>
							<option value="">Sexo</option>
							<option value="M">Masculino</option>
							<option value="F" selected>Feminino</option>
						<?php } ?>
					</select>
					<select name="estC" id="estC" required>
						<?php if($reg['estCivil'] == "SO"){ ?>
							<option value="SO" selected>Solteiro (a)</option>
							<option value="CA">Casado (a)</option>
						<?php }else { ?>
							<option value="SO">Solteiro (a)</option>
							<option value="CA" selected>Casado (a)</option>
						<?php } ?>
					</select>
				</div>
				<input type="text" name="cep" id="cep" value="<?php echo $reg['cep']; ?>" onkeypress="this.value = formCep(event)" required maxlength="9" size="9" class="tam place" placeholder="Cep">
				<a href="#" class="btn btn-primary m-1 pesquisar">Pesquisar</a><a href="http://www.buscacep.correios.com.br/" target="_blank" class="btn btn-primary m-1">Não sei o CEP</a><br>
				<input type="text" name="estado" id="estado" value="<?php echo $reg['estado']; ?>" maxlength="25" required size="25"  class="tam place" readonly="" placeholder="Estado">
				<input type="text" name="cid" id="cid" value="<?php echo $reg['cidade']; ?>" maxlength="50" size="50" required class="tam place" readonly="" placeholder="Cidade">
				<input type="text" name="bairro" id="bairro" value="<?php echo $reg['bairro']; ?>" maxlength="50" size="50" class="tam place" readonly="" placeholder="Bairro">
				<input type="text" name="rua" id="rua" value="<?php echo $reg['rua'];?>" maxlength="30" size="30" class="place" readonly="" placeholder="Rua">
				<input type="text" name="numero" id="numero" value="<?php echo $reg['numero']; ?>" maxlength="5" required size="5" class="tam place" placeholder="Número">
				<input type="text" name="com" id="com" value="<?php echo $reg['complemento']; ?>" maxlength="15" size="15" class="tam place" placeholder="Complemento">
				<input type="text" name="telC" id="telC" value="<?php echo $reg['telmovel']; ?>" maxlength="15" size="15" required class="tam place" placeholder="Telefone Celular">
				<input type="text" name="telF" id="telF" value="<?php echo $reg['telfixo']; ?>" maxlength="14" size="14" class="tam place"  placeholder="Telefone fixo">
				<input type="file" name="arquivo" id="arquivo" class="tam ar place">
				<input type="hidden" name="arq" id="arq" value="<?php echo $reg['foto']; ?>">
				<input type="hidden" name="v" id="id_cep_alter" value="<?php echo $reg['id']; ?>">
				<input type="hidden" name="tabela" value="formAlterCliente">
				<input type="submit" class="btn btn-primary" value="Alterar">
			<?php
				}
			?>
		</form>
		<div class="spinner">
		</div>
	</div>
	<?php
		require_once "../../lib/dep-script.php";
	?>
</body>
</html>