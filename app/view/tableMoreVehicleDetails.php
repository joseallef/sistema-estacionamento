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
    <title>Veiculos</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png" />
</head>

<body>
    <?php
    require_once "menu.php";
    require_once "../controllers/Criptor.php";
    require_once "../../vendor/autoload.php";

    use AppC\Criptor;
    use AppC\Veiculo;

    $criptor = new Criptor();
    $veiculo = new Veiculo;
    ?>
    <div class="option-search">
        <form action="" method="POST">
            <div class="text text-center mt-4 fixed bg-dark p-3 text-warning">
                <h3>Mais detalhes</h3>
            </div>
        </form>
    </div>
    <div class="container-field mt-0">
        <?php
        $function = $veiculo->listarTodosVeiculos();
        $counter = 0;
        foreach ($function as $reg) {
            $counter++;
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Ativos</th>
                    <th>Inativos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img src="public/img/circle-green.png" alt="Ativo">
                    </td>
                    <td>
                        <img src="public/img/circle-red.png" alt="Inativo">
                    </td>
                    <td><?php echo $counter; ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Responsável</th>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th class="mr-5">Situação</th>
                    <th class="mr-5">Excluir</th>
                </tr>
            </thead>
            <?php
            if (!empty($function)) {
                foreach ($function as $reg) {
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $reg['nome']; ?></td>
                            <td><?php echo $reg['placa']; ?></td>
                            <td><?php echo $reg['marca']; ?></td>
                            <td><?php echo $reg['modelo']; ?></td>
                            <td><?php echo $reg['cor']; ?></td>

                            <td>
                                <?php
                                if ($reg['situacao'] == 'I') {
                                ?>
                                    <img src="public/img/circle-red.png" alt="Inativo">
                                <?php
                                } elseif ($reg['situacao'] == 'A') {
                                ?>
                                    <img src="public/img/circle-green.png" alt="Ativo">
                                <?php
                                }
                                ?>
                            </td>
                            <td><button data-toggle="modal" class="btn btn-danger excluir-veiculo-permanentimente" value="<?php echo $reg['id']; ?>"><img src="public/img/icondelete.png"></button></td>
                        </tr>
                    </tbody>
                    <!-- Modal -->
                    <!-- confirmar delet de veiculo -->
                    <?php
                    if (isset($_GET['delete']) && $_GET['delete'] == '1') {
                    ?>

                        <div class="modal fade" id="excluir-veiculo-permanentimente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text text-center">
                                        <h3>Registro apagado com sucesso!</h3>
                                        <div class="spinner-border spinner-border-md" style="width: 6rem; height: 6rem;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer" data-dismiss="modal" aria-label="Close">
                                        <button type="button" class="btn btn-success">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </table>
        <?php
        if (isset($_SESSION['nao_autenticado'])) :
        ?>
            <div class="alert alert-danger text-center z-index-0">
                <p>Nenum registro encontrado!</p>
            </div>
        <?php
        endif;
        unset($_SESSION['nao_autenticado']);
        ?>
    </div>
    <?php
    require_once "../../lib/dep-script.php";
    ?>
</body>

</html>