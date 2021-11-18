<?php
session_start();
require_once "../../vendor/autoload.php";

use AppC\Token;

$token = new Token();
if ($token->checkAuth()) {
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Clientes</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png" />
</head>

<body>
    <?php
    require_once "menu.php";
    require_once "../controllers/Cliente.php";

    use AppC\Criptor;
    use AppC\ExCliente;

    $criptor = new Criptor();

    use AppC\Cliente;

    $cliente = new Cliente();
    $exCli = new ExCliente();
    ?>
    <div class="option-search">
        <div class="text text-center bg-dark mt-0 p-3 text-warning">
            <h3>Mais detalhes</h3>
        </div>
    </div>

    <div class="container-field" id="topo">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Clientes ativos</th>
                    <th>Clientes inativos</th>
                    <th>Total de clientes</th>
                </tr>
            </thead>
            <?php
            $todosCliente = $cliente->listarTodosClientes();
            $clientesAtivos = $cliente->listarTodosClientesAtivos();
            $clientesInativos = $cliente->listarTodosClientesInativos();

            $contTodosCliente = 0;
            $contTodosClienteAtivos = 0;
            $contTodosClienteInativos = 0;

            if ($todosCliente != '') {
                foreach ($todosCliente as $value) {
                    $contTodosCliente++;
                }
                foreach ($clientesAtivos as $value) {
                    $contTodosClienteAtivos++;
                }
                foreach ($clientesInativos as $value) {
                    $contTodosClienteInativos++;
                }
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $contTodosClienteAtivos ?></td>
                        <td><?php echo $contTodosClienteInativos ?>
                            <a href="#cliente-inativo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                                    <path fill-rule="evenodd" d="M13.03 8.22a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0L3.47 9.28a.75.75 0 011.06-1.06l2.97 2.97V3.75a.75.75 0 011.5 0v7.44l2.97-2.97a.75.75 0 011.06 0z"></path>
                                </svg>
                            </a>
                        </td>
                        <td><?php echo $contTodosCliente ?></td>
                    </tr>
                </tbody>
        </table>
        <table class="table table-hover">
            <h2 class="text-center">Clientes ativos</h2>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data entrada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($clientesAtivos as $value) {
                ?>

                    <tr>
                        <td><?php echo $value['nome']; ?></td>
                        <td><?php echo $value['data_entrada']; ?></td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
        <table class="table table-hover">
            <h2 class="text-center mt-5" id="cliente-inativo">Clientes inativos</h2>
            <div class="text-center">
                <a href="#topo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                        <path fill-rule="evenodd" d="M3.47 7.78a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0l4.25 4.25a.75.75 0 01-1.06 1.06L9 4.81v7.44a.75.75 0 01-1.5 0V4.81L4.53 7.78a.75.75 0 01-1.06 0z"></path>
                    </svg>
                    Topo
                </a>
            </div>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data entrada</th>
                    <th>Data saida</th>
                    <th>Tempo Dias/meses/ano</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($exCli->listarTodosExClientes() as $value) {
                    $data_saida = $value['data_saida'];

                    $new_data_saida = explode('/', $data_saida);
                    $new_data_entrada = explode('/', $value['data_entrada']);

                    $new_data_saida = strtotime("$new_data_saida[0]");
                    $new_data_entrada = strtotime("$new_data_entrada[0]");
                    $som_new_date = ($new_data_saida - $new_data_entrada) / 86400;

                    $dias = ($som_new_date / 30);
                    $meses = ($som_new_date / 30) % 86400;
                    $ano = ($meses / 12);
                ?>

                    <tr>
                        <td><?php echo $value['nome']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($value['data_entrada'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($value['data_saida'])); ?></td>
                        <td><?php echo $som_new_date . " / " . $meses . " / " . number_format($ano, 1); ?></td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        <?php

            } elseif (isset($todosCliente) && $todosCliente == "" || isset($_POST['nome']) && $_POST['nome'] == "") {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="cadSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text text-center">
                                <h3>Dados não encontrado!</h3>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </table>
    </div>
    <?php
    if (isset($_GET['valor']) && $_GET['valor'] == "cadSuccess") {
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
                        <a href="clientes" class="btn btn-primary">Fechar</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <?php
    }
    ?>
    <?php require_once "../../lib/dep-script.php"; ?>
</body>

</html>