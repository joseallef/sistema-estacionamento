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
    <title>Gerar Boleto</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png" />
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
                    <input type="submit" class="button mt-4" id="pesquisar" value="Pesquisar">
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
                            <th>Este més</th>
                            <th>Enviar</th>
                            <th>Gerar Boleto</th>
                            <th>Alterar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['option-selected']) && !empty($_POST['option-selected'])) {
                            $selected = $_POST['option-selected'];
                            if ($selected == 'NOME') {
                                $function = $cliente->listarDadosFinanceiroPorNome($_POST['nome']);
                            } elseif ($selected == 'DATA') {
                                $function = $cliente->listarDadosFinanceiroPorData($_POST['selected_date']);
                            } else {
                                $function = $cliente->listarTodosDadosFinanceiro();
                            }
                        }
                        if (isset($function) && $function != '') {
                            $fullNumber = '0';
                            foreach ($function as $value) {
                                // var_dump(strlen($value['telmovel']), $value['telmovel']);
                                // var_dump($value['dt_geracao'], !empty($value['dt_geracao']));
                                if (strlen($value['telmovel']) > 13) {
                                    $whatsapp = explode(' ', $value['telmovel']);
                                    $dddPrimary = explode('(', $whatsapp[0]);
                                    $dddSecondary = explode(')', $dddPrimary[1]);
                                    $ddd = $dddSecondary[0];
                                    $number = explode('-', $whatsapp[1]);
                                    $fullNumber = $ddd . $number[0] . $number[1];
                                } else {
                                    $fullNumber = '0000000000';
                                }
                        ?>
                                <tr>
                                    <td><?php echo $value['nome']; ?></td>
                                    <td><?php echo $value['vencimento']; ?></td>
                                    <td><?php echo $value['valor']; ?></td>
                                    <?php if ($value['numboleto'] != null || $value['numboleto'] != "") { ?>
                                        <td><a href="controller-boleto?tabela=boleto_gerado&v=<?php echo $value['numboleto']; ?>" class="btn btn-primary" target="_blank"><img src="public/img/document.png"></a></td>
                                    <?php } else {
                                        echo "<td></td>";
                                    } ?>
                                    <td><?php
                                        if (!empty($value['dt_geracao'])) {
                                            $month = explode('-', $value['dt_geracao']);
                                            if ($month[1] == date('m')) {
                                                echo '<img src="public/img/processo_sucess.gif">';
                                            } else {
                                                echo '<img src="public/img/processo_waiting.gif">';
                                            }
                                        } else {
                                            echo $value['dt_geracao']; {
                                                echo '<img src="public/img/processo_waiting.gif">';
                                            }
                                        }
                                        ?></td>
                                    <td><a href="https://wa.me/55<?php echo $fullNumber ?>" target="_blank" class="btn btn-success"><img src="public/img/whatsapp.png" alt="Alterar"></a></td>
                                    <td><a href="controller-boleto?tabela=form_gera_boleto&v=<?php echo $value['id']; ?>" class="btn btn-secondary" target="_blank"><img src="public/img/document.png"></a></td>
                                    <td><a href="alterar-financeiro?v=<?php echo $value['id']; ?>" class="btn btn-danger link-info"><img src="public/img/icon.png" alt="Alterar"></a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                if (isset($_GET['boleto']) && $_GET['boleto'] == "Existente") {
                ?>
                    <div class="modal fade" id="notFoud" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="notFoud" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                </div>
                                <div class="modal-body">
                                    <div class="text text-center">
                                        <h3>Já existe um boleto gerado para essa data!</h3>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <buttom class="btn btn-primary" id="windowClose">Fechar</buttom>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        <?php
                }
        ?>
        <?php
        if (isset($_GET['gerarboleto']) && $_GET['gerarboleto'] == "error") {
        ?>
            <div class="modal fade" id="notFoud" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="notFoud" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text text-center">
                                <h3>Ooops! algo deu errado.</h3>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <buttom class="btn btn-primary" id="windowClose">Fechar</buttom>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php
        }
?>
</div>
<?php
if (isset($_SESSION['nao_autenticado'])) :
?>
    <div class="alert alert-danger text-center z-index-0">
        <p>Boleto já gerado para essa data!</p>
    </div>
<?php
endif;
unset($_SESSION['nao_autenticado']);
?>
</main>
</div>
<?php require_once "../../lib/dep-script.php"; ?>
</body>

</html>