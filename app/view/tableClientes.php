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

    $criptor = new Criptor();

    use AppC\Cliente;

    $cliente = new Cliente();
    ?>
    <div class="option-search">
        <form action="" method="POST" id="idform">
            <div class="text text-center bg-dark mt-0 p-3 text-warning">
                <h3>Clientes</h3>
                <div class="icone-option">
                    <i class="fas fa-search bg-white"></i>
                </div>
                <div class="option-pesq bg-dark">
                    <button class="btn btn-primary" id="todos" name="todos">Todos</button>
                    <hr color="white">
                    <input type="text" name="nome" id="nome" value="" placeholder="Nome ou CPF/CNPJ">
                    <button type="submit" id="btn-pesquisa" class="btn btn-primary">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-field">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cpf/CNPJ</th>
                    <th>Cep</th>
                    <th>UF</th>
                    <th>Cidade</th>
                    <th>Bairro</th>
                    <th>Rua</th>
                    <th>Nº </th>
                    <th>Tel Celular</th>
                    <th>Mais</th>
                </tr>
            </thead>
            <?php
            if (isset($_POST['todos'])) {
                $function = $cliente->listarTodosClientesAtivos();
            } elseif (isset($_POST['nome']) && $_POST['nome'] != null) {
                $function = $cliente->listarCliente($_POST['nome']);
            }

            if (isset($function) && $function != '') {
                foreach ($function as $value) {
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $value['nome']; ?></td>
                            <td><?php echo $value['cpf']; ?></td>
                            <td><?php echo $value['cep']; ?></td>
                            <td><?php echo $value['estado']; ?></td>
                            <td><?php echo $value['cidade']; ?></td>
                            <td><?php echo $value['bairro']; ?></td>
                            <td><?php echo $value['rua']; ?></td>
                            <td><?php echo $value['numero']; ?></td>
                            <td><?php echo $value['telmovel']; ?></td>

                            <td><a href="mais-dados-clientes?v=<?php echo $criptor->base64($value['id'], 1); ?>" class="btn btn-info"><img src="public/img/iconadd.png"></a></td>
                        </tr>
                    </tbody>
                <?php
                }
            } elseif (isset($function) && $function == "" || isset($_POST['nome']) && $_POST['nome'] == "") {
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