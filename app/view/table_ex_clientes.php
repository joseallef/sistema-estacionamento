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
    date_default_timezone_set('America/Sao_Paulo');
    require_once "../../vendor/autoload.php";

    use AppC\ExCliente;
    use AppC\Criptor;
    use AppC\Veiculo;

    $exCli = new ExCliente();
    $criptor = new Criptor();
    $veiculo = new Veiculo();
    ?>
    <div class="container-field mt-5">
        <table class="table mt-5">
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Tel Celular</th>
                <th>Cpf</th>
                <th>Cep</th>
                <th>UF</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th>Rua</th>
                <th>Nº</th>
            </tr>
            <?php
            foreach ($exCli->listarExClientePorId($_GET['id']) as $reg) {
                $id = $reg['id'];
                $nome = $reg['nome'];
                $data_entrada = $reg['data_entrada'];
            ?>
                <tr>
                    <td><img src="public/image/<?php echo $reg['foto']; ?>" class="rounded" /></td>
                    <td><?php echo $reg['nome']; ?></td>
                    <td><?php echo $reg['email']; ?></td>
                    <td><?php echo $reg['cpf']; ?></td>
                    <td><?php echo $reg['telmovel']; ?></td>
                    <td><?php echo $reg['cep']; ?></td>
                    <td><?php echo $reg['estado']; ?></td>
                    <td><?php echo $reg['cidade']; ?></td>
                    <td><?php echo $reg['bairro']; ?></td>
                    <td><?php echo $reg['rua']; ?></td>
                    <td><?php echo $reg['numero'];
                        echo " " . $reg['complemento']; ?></td>
                </tr>
            <?php
            }
            ?>

        </table>
    </div><br>
    <div class="container mt-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Data Entrada</th>
                    <th>Data Saida</th>
                    <th>Tempo Dias/meses/ano</th>
                    <th>Voltar a ser Cliente</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($exCli->listaInformacoesCliente($_GET['id']) as $reg) {
                    $desc = $reg['descricao'];
                    $data_saida = $reg['data_saida'];

                    $new_data_saida = explode('/', $data_saida);
                    $new_data_entrada = explode('/', $data_entrada);

                    $new_data_saida = strtotime("$new_data_saida[0]");
                    $new_data_entrada = strtotime("$new_data_entrada[0]");
                    $som_new_date = ($new_data_saida - $new_data_entrada) / 86400;

                    $dias = ($som_new_date / 30);
                    $meses = ($som_new_date / 30) % 86400;
                    $ano = ($meses / 12);

                ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($data_entrada)); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($data_saida)); ?></td>
                        <td><?php echo $som_new_date . " / " . $meses . " / " . number_format($ano, 1); ?></td>
                        <td>
                            <form action="alter-cliente" method="POST">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                <input type="hidden" name="tabela" value="alterExCliente">
                                <button type="submit" class="btn btn-info">Ativar</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Motivo da saida</th>
                </tr>
            </thead>
            <tbody>
                <div class="text text-center">
                    <tr class="">
                        <td class=""><?php echo $desc ?></td>
                    </tr>
                </div>
</body>
</table>
</div>
<div class="container">
    <table class="table">
        <thead>
            <div class="text text-center">
                <span class="btn btn-info">Veículos vinculados A: <?php echo $nome ?></span>
            </div>
            <tr>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Cor</th>
                <th>Marca</th>
            </tr>
        </thead>
        <?php
        if ($veiculo->exibeCarrosExCliente($id) != '') {
            foreach ($veiculo->exibeCarrosExCliente($id) as $reg) {
        ?>
                <tbody>
                    <tr>
                        <td><?php echo $reg['placa']; ?></td>
                        <td><?php echo $reg['modelo']; ?></td>
                        <td><?php echo $reg['cor']; ?></td>
                        <td><?php echo $reg['marca']; ?></td>
                    </tr>
                </tbody>
            <?php
            }
        } else { ?>
            <tbody>
                <tr>
                    <td colspan="7">
                        <h2 class='btn btn-info text text-center p-3'>Não Há veiculos vinculado ao ex-cliente</h2>
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