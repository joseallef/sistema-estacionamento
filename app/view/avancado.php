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
    <title>Avançado</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png" />
    <link rel="stylesheet" href="app/view/style/panel-control.css">
</head>

<body>
    <?php
    require_once "menu.php";
    require_once "../../vendor/autoload.php";

    use AppC\ExCliente;

    $exCli = new ExCliente;
    ?>
    <div class="containe">
        <div class="container-fluid con">
            <form action="conteudo-avancado" method="POST" class="form">
                <div class="text text-center m-3 mb-0">
                    <button class="btn btn-dark" name="ex-clientes">Ex-Clientes</button>
                    <button class="btn btn-dark" name="contro_acesso">Painel de Controle</button>
                </div>
                <?php
                if (isset($_POST['ex-clientes'])) {
                ?>
                    <div class="text text-center bg-dark mt-0 p-2 text-warning">
                        Ex-Clientes
                    </div>
                    <div class="text text-center m-2 mb-0">
                        <button class="btn btn-dark text-warning" name="especificar">Especificar</button>
                        <button class="btn btn-dark text-warning" name="todos">Todos</button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (isset($_POST['contro_acesso'])) {
                ?>
                    <div class="container-customized">
                        <fieldset class="option-finance">
                            <div class="select-block">
                                <a href="mais-detahes-clientes" class="btn btn-white">
                                    <div class="btn btn-primary display-block">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <span>Mais detalhes clientes</span>
                                </a>
                            </div>
                            <div class="select-block">
                                <a href="mais-detahes-veiculos" class="btn btn-white">
                                    <div class="btn btn-primary display-block">
                                        <i class="fa fa-car"></i>
                                    </div>
                                    <span>Mais detalhes veiculos</span>
                                </a>
                            </div>
                        </fieldset>
                    </div>
                <?php
                }
                ?>

                <?php
                if (isset($_POST['especificar'])) {
                ?>
                    <div class="text text-center bg-dark mt-0 p-2 text-warning">
                        Ex-Clientes
                    </div>
                    <div class="text text-center m-1">
                        <span class="ex">Busca especifica por</span>
                        <select name="option" id="option" class="col-xs-4">
                            <option value="">Celecione</option>
                            <option value="Nome">Nome</option>
                            <option value="CPF">CPF</option>
                            <option value="Placa">Placa</option>
                            <option value="data">Data</option>
                        </select>
                    <?php
                }
                    ?>

                    <div class="nome alert alert-dark input-none" role="alert">
                        <input type="text" class="tam" name="nome" value="" placeholder="Nome...">
                        <button class="btn btn-primary">Pesquisar</button>
                    </div>
                    <div class="cpf input-none">
                        <input type="text" class="tam cpf " maxlength="14" id="cpf1" name="cpf" placeholder="000.000.000-00" onkeypress="this.value = formatcpf(event)" onpaste="return false;">
                        <button class="btn btn-primary">Pesquisar</button>
                    </div>
                    <div class="Placa input-none">
                        <input type="text" class="tam" id="placa" name="placa" placeholder="MJK-6453">
                        <button class="btn btn-primary" name="historico">Pesquisar</button>
                    </div>
                    <div class="data input-none">
                        <input type="date" class="tam data" name="data_inicio" placeholder="data inicio">
                        <input type="date" class="tam data" name="data_fim" placeholder="data fim">
                        <button class="btn btn-primary">Pesquisar</button>
                    </div>
                    </table>
                    <?php
                    if (isset($_POST['nome']) && ($_POST['nome'] != null)) {
                        $function = $exCli->listarExclientePorNome($_POST['nome']);
                    }

                    if (isset($_POST['cpf']) && ($_POST['cpf'] != null)) {
                        $function = $exCli->listarExclientePorCpf($_POST['cpf']);
                    }
                    if (isset($_POST['placa']) && ($_POST['placa'] != null)) {
                        $function = $exCli->buscarExClientePorplaca($_POST['placa']);
                    }
                    if (isset($_POST['data_inicio']) && ($_POST['data_inicio'] != null) && ($_POST['data_fim'] != null)) {
                        $function = $exCli->listarExclientePorData($_POST['data_inicio'], $_POST['data_fim']);
                    }

                    if (isset($_POST['todos']) && $_POST['todos'] !== false) {
                        $function = $exCli->listarTodosExClientes();
                    }


                    if (isset($function) && $function != "" && empty($_POST['placa'])) {
                    ?>
                        <table class="table table-hover nome_celected">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cpf</th>
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
                            foreach ($function as $reg) {
                            ?>
                                <tbody class="table table-hover">
                                    <tr>
                                        <td><?php echo $reg['nome']; ?></td>
                                        <td><?php echo $reg['cpf']; ?></td>
                                        <td><?php echo $reg['cep']; ?></td>
                                        <td><?php echo $reg['estado']; ?></td>
                                        <td><?php echo $reg['cidade']; ?></td>
                                        <td><?php echo $reg['bairro']; ?></td>
                                        <td><?php echo $reg['rua']; ?></td>
                                        <td><?php echo $reg['numero'];
                                            echo " " . $reg['complemento']; ?></td>
                                        <td><?php echo $reg['telmovel']; ?></td>
                                        <td><a href="mais-dados-ex-clientes?id=<?php echo $reg['id']; ?>" class="btn btn-primary"><img src="public/img/iconadd.png"></a></td>
                                    </tr>
                                </tbody>
                        <?php
                            }
                        }
                        ?>
                        </table>
                        </table>

                        <?php
                        if (isset($_POST['placa']) && ($_POST['placa'] != null)) {
                        ?>
                            <table class="table mt-5">
                                <thead>
                                    <tr>
                                        <th>Nome do Responsável</th>
                                        <th>Placa</th>
                                        <th>Modelo</th>
                                        <th>Cor</th>
                                        <th>Marca</th>
                                        <th class="mr-5">Mais</th>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($exCli->buscarExClientePorplaca($_POST['placa']) as $reg) {

                                ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $reg['nome'] ?></td>
                                            <td><?php echo $reg['placa']; ?></td>
                                            <td><?php echo $reg['modelo']; ?></td>
                                            <td><?php echo $reg['cor']; ?></td>
                                            <td><?php echo $reg['marca']; ?></td>
                                            <td><a href="mais-dados-ex-clientes?id=<?php echo $reg['id']; ?>" class="btn btn-primary"><img src="public/img/iconadd.png"></a></td>
                                        </tr>
                                    </tbody>
                            <?php
                                }
                            }
                            ?>
                            </table>
                    </div>
            </form>
        </div>
    </div>
    <?php require_once "../../lib/dep-script.php"; ?>
</body>

</html>