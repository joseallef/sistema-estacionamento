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
        <title>Cadastro de Clientes</title>
        <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
    </head>
    <body>
    <?php
        require_once 'menu.php';
        require_once "../controllers/ClienteAvulso.php";
        use AppC\ClienteAvulso;
        $clienteAvulso = new ClienteAvulso();
    ?>
        <div class="container-field mt-5">
            <table class="table table-hover mt-5">
				<thead>
					<tr>
                        <th>Nome</th>
                        <th>CPF/RG</th>
                        <th>Celular</th>
                        <th>Placa</th>
                        <th>Data</th>
                        <th>Hora Entrada / Saida</th>
                        <th>Tempo</th>
                        <th colspan="2">Opções</th>
					</tr>
				</thead>
				<?php
                    foreach($clienteAvulso->buscar() as $reg)
                    {
                        $hora_entrada = $reg['hora_entrada'];
                        $hora_saida = $reg['hora_saida'];
                        $date = date("d/m/Y", strtotime($reg['data']));
                        
                        $hora_entrada1 = new DateTime($hora_entrada);
                        $hora_saida1 = new DateTime($hora_saida);
                        $resul = $hora_entrada1->diff($hora_saida1);
                        if($hora_saida !== ''){
                            $resul = $resul->format('%H:%I:%S');
                        }else{
                            $resul = "0.0";
                        }
				?>
				<tbody>
					<tr>
						<td><?php echo $reg['nome']; ?></td>
						<td><?php echo $reg['rg_cpf']; ?></td>
						<td><?php echo $reg['celular']; ?></td>
						<td><?php echo $reg['placa']; ?></td>
                        <td><?php echo $date ?></td>
                        <td><?php echo $hora_entrada." / ".$hora_saida; ?></td>
                        <td><?php echo $resul; ?></td>
                    <?php
                        if(!$hora_saida)
                        {
                    ?>
                        <td><a href="cliente-avulso?v=<?php echo $reg['id']; ?>&saida=saida-cliente-avulso" class="btn btn-primary calcular">Sair</a></td>
                    <?php
                        }
                    ?>  <td><a href="" class="btn btn-primary imprimir" aria-disabled="true"><img src="public/img/iconadd.png"></a>
                        </td>
					</tr>
				</tbody>
				<?php
					}
				?>
            </table>
        </div>
        <?php
		    require_once "../../lib/dep-script.php";
	    ?> 
    </body>
</html>