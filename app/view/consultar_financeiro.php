<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();
    if($token->checkAuth()){}else{header("Location: index.php");}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opções financeiras</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
    <link rel="stylesheet" href="app/view/style/page-finance.css">
</head>
<body>
    <?php    
        require_once "menu.php";
        use AppC\Financeiro;
        $financeiro = new Financeiro();
    ?>
    <div class="container-customized">
        <section class="option-finance">
            <form action="" method="POST" id="search-finance" onsubmit="validation(this); return true;">
                <div class="select-block">
                    <label for="mes_atual">Filtrar Por</label>
                    <select name="option-selected" id="consultar-por" required>
                        <option value="">Selecione</option>
                        <option value="TODOS">Todos</option>
                        <option value="VENCIDOSAVENCER">Vencidos a vencer</option>
                        <option value="EXPIRADOS">Expirados</option>
                        <option value="PAGOS">Pagos</option>
                        <option value="TODOSBAIXADOS">Todos Baixados</option>
                    </select>
                </div>
                <div class="select-block">
                    <label for="gerar_boleto">Data Inicio</label>
                    <input type="date" name="data_inicio" required>
                </div>
                <div class="select-block">
                    <label for="historico">Data Fim</label>
                    <input type="date" name="data_fim" required>
                </div>
                <div>
                </div>
                <div>
                    <input type="submit" class="button" id="btn-pesquisar" value="Pesquisar">
                    <input type="hidden" name="numeroPagina" id="numeroPagina" value="">
                </div>
               </form>
        </section>
        <main>
            <div class="scroll">
                <?php
                    if(isset($_POST['option-selected']))
                    {
                    $response = $financeiro->consultaFinanceiro($_POST['option-selected'], $_POST['data_inicio'], $_POST['data_fim'], $_POST['numeroPagina']);
                ?>
                    <div class="select-pagina">
                    <select name="pagina" id="pagina" required>
                <?php
                    for($i = 0; $i < $response['totalPages']; $i++)
                    {
                ?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>                    
                <?php
                    }
                ?>
                    </select>
                    </div>
                <table class="table table-hover">
                    <thead>
                        <th>Nome</th>
                        <th>Data Vencimento</th>
                        <th>Data Pagamento</th>
                        <th>Valor</th>
                        <th>Situação</th>
                    </thead>
                    <?php
                    foreach($response as $values)
                    {
                        if($response['content'])
                        {
                            foreach($values as $data_financ)
                            {
                                if(isset($data_financ['nomeSacado']) && $data_financ['nomeSacado'] !== null)
                                {
                        ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $data_financ['nomeSacado']; ?></td>
                                    <td><?php echo $data_financ['dataVencimento']; ?></td>
                                    <td><?php if(isset($data_financ['dataPagtoBaixa'])){ echo $data_financ['dataPagtoBaixa']; }else{ echo ""; } ?></td>
                                    <td><?php echo $data_financ['valorNominal']; ?></td>
                                <?php if($data_financ['situacao'] == "PAGO")
                                        {?>
                                    <td><img src="public/img/circle-green.png" alt="Pago"><?php echo $data_financ['situacao']; ?></td>
                                <?php   } ?>
                                <?php if($data_financ['situacao'] == "EMABERTO")
                                        {?>
                                <td><img src="public/img/circle-yellow.png" alt="EMABERTO"><?php echo $data_financ['situacao']; ?></td>
                                <?php } ?>
                                <?php if($data_financ['situacao'] == "VENCIDO")
                                        {?>
                                    <td><img src="public/img/circle-red.png" alt="VENCIDO"><?php echo $data_financ['situacao']; ?></td>
                                <?php } ?>
                                <?php if($data_financ['situacao'] == "EXPIRADO")
                                        {?>
                                <td><img src="public/img/circle-red.png" alt="EXPIRADO"><?php echo $data_financ['situacao']; ?></td>
                                <?php } ?>
                                <?php if($data_financ['situacao'] == "BAIXADO")
                                        {?>
                                <td><img src="public/img/circle-green.png" alt="BAIXADO"><?php echo $data_financ['situacao']; ?></td>
                                <?php } ?>
                                </tr>
                            </tbody>
                        <?php
                                }
                            }
                        }
                    }
                        if(!$values)
                        {
                        ?><div class='text text-center'><h2 class='btn btn-info text text-center p-3'>Não há dados</h2></div>
                    <?php
                        }
                        }
                    ?>
                </table>
            </div>
        </main>
    </div>
    <?php
		require_once "../../lib/dep-script.php";
	?>
</body>
</html>