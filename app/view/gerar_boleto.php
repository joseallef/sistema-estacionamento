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
		<title>Gerar Boleto</title>
		<link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/>
        <link rel="stylesheet" href="app/view/style/page-finance.css">
    </head>
    <body>
	<?php
		require_once "menu.php";
		require_once "../controllers/Cliente.php";
		use AppC\Criptor;
		$criptor = new Criptor();

		use AppC\Cliente;
		$cliente = new Cliente();
	?>
    <div class="container-customized">
        <section class="option-finance">
            <form action="" method="POST" id="search-finance" onsubmit="valid(this); return true;">
                <div class="select-block">
                    <label for="mes_atual">Pesquisar Por</label>
                    <select name="option-selected" id="consultar-por" required>
                        <option value="">Selecione</option>
                        <option value="TODOS">Todos os Cliente</option>
                        <option value="NOME">Nome do Cliente</option>
                        <option value="DATA">Data de Vencimento</option>
                    </select>
                </div>
                <div class="select-block options-search">
                </div>
                <div class="select-block">
                    <input type="submit" class="button mt-4" id="" value="Pesquisar">
                </div>
            </form>
        </section>
        <main>        
            <div class="scroll">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data Vencimento</th>
                            <th>Valor</th>
                            <th>Boleto gerado</th>
                            <th>Gerar Boleto</th>
                            <th>Alterar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(isset($_POST['option-selected']) && !empty($_POST['option-selected'])){
                            $selected = $_POST['option-selected']; 
                            if($selected == 'NOME'){$function = $cliente->listarDadosFinanceiroPorNome($_POST['nome']);}
                            elseif($selected == 'DATA'){$function = $cliente->listarDadosFinanceiroPorData($_POST['selected_date']);}
                            else{$function = $cliente->listarTodosDadosFinanceiro();}
                        }
                        
                        if(isset($function) && $function !=''){
                        foreach($function as $value){
                    ?>				
                        <tr>
                            <td><?php echo $value['nome'];?></td>
                            <td><?php echo $value['vencimento'];?></td>
                            <td><?php echo $value['valor'];?></td>
                            <?php if($value['numboleto'] != null || $value['numboleto'] != ""){ ?>
                            <td><a href="controller-boleto?tabela=boleto_gerado&v=<?php echo $value['numboleto']; ?>" class="btn btn-primary" target="_blank"><img src="public/img/document.png"></a></td>
                    <?php }else{echo "<td></td>";} ?>
                            <td><a href="controller-boleto?tabela=form_gera_boleto&v=<?php echo $value['id']; ?>" class="btn btn-primary" target="_blank"><img src="public/img/document.png"></a></td>
                            <td><a href="alterar-financeiro?v=<?php echo $value['id']; ?>" class="btn btn-primary"><img src="public/img/icon.png" alt="Alterar"></a></td>
                        </tr>
                    
                    <?php
                        }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
		<?php require_once "../../lib/dep-script.php"; ?> 
	</body>
</html>