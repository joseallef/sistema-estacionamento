<?php
session_start();
require_once "../../vendor/autoload.php";
require_once "../controllers/Token.php";

use AppC\Token;

$token = new Token();
if ($token->checkAuth()) {
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vagas</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <?php
    require_once "menu.php";
    ?>
    <div class="containe vagas">
        <form action="update-veiculo" method="POST" class="vagas">
            <div class="text text-center containe-vaga">
                <label for="">Nova Vaga</label><label for="">Excluir Vaga</label><br>
                <div class="botao">
                    <button class="btn btn-primary p-2" type="submit" name="tabela" value="add_vaga"><img src="public/img/iconadd.png"></button>
                    <button class="btn btn-primary p-2" type="submit" name="tabela" value="excluir_vaga"><img src="public/img/icons8-menos-48.png"></button>
                </div>
            </div>
            <hr>
            <div class="containe-vaga2">

            </div>
            <hr>
        </form>
        <?php
        $vagasOcup = 0;
        $resul_v_disp = 0;
        /* $vagasDisp = ($cont - $cont2) * 100;
            $vagasOcup = ($cont2 * 100) / $cont;
            $resul_v_disp = $vagasDisp/$cont;*/

        ?>

        <div class="text text-right info">
            <input type="hidden" name="vagasOcup" class="vagasOcup" value="<?php echo $vagasOcup ?>">
            <input type="hidden" name="vagasDisp" class="vagasDisp" value="<?php echo $resul_v_disp ?>">
            <!--<label class="color bg-danger"></label><?php echo number_format($vagasOcup, 1, ',', ''); ?>%  <span>Ocupadas</span><br>
            <label class="color bg-success"></label><?php echo number_format($resul_v_disp, 1, ',', ''); ?>% <span>Disponiveis</span>-->
            <div id="chart_div"></div>
        </div>
    </div>
    <?php require_once "../../lib/dep-script.php"; ?>
</body>

</html>