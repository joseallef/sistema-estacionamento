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
        <title>Alterar Veículo</title>
        <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
    </head>
    <body>
    <?php
        require_once "menu.php";
        require_once "../controllers/Criptor.php";
        require_once "../../vendor/autoload.php";  
        use AppC\Criptor;
        use AppC\Veiculo;
        $objControl = new Criptor;
        $veiculo = new Veiculo;
        ?>
    <div class="containe">
        <form action="update-veiculo" method="POST" enctype="multpart/form-data" class="form">
            <div class="row text-center">
                <?php
                    $id = $objControl->base64($_GET['v'], 2);
                    foreach($veiculo->selecionaId($id) as $reg)
                    {
                ?>
                <div class="text-center col-sm-12">
                    <label>Nome do Responsavel</label>
                    <input type="text" name="nomeRes" style="background: #EEEEEE;" value="<?php echo $reg['nome'] ?>" readonly="">
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-lg-6 text-center col-md-6 col-xs-12">
                    <label for="">Placa:</label>
                    <input type="text" required name="placa" id="placa" value="<?php echo $reg['placa']; ?>" placeholder="AAA-0000">
                </div>
 
                <div class="col-lg-6 text-center">
                    <label>Marca:</label><br>
                <select name="marcaCar" id="marca">
                    <option value="" >Selecione</option>
                    <option value="6" <?php if ($reg['marca'] == 'Audi') echo "selected='selected'"; ?>>Audi</option>
                    <option value="7" <?php if ($reg['marca'] == 'BMW') echo "selected='selected'"; ?>>BMW</option>
                    <option value="13" <?php if ($reg['marca'] == 'Citroén') echo "selected='selected'"; ?>>Citroén</option>
                    <option value="161" <?php if ($reg['marca'] == 'Chery') echo "selected='selected'"; ?>>Chery</option>
                    <option value="23" <?php if ($reg['marca'] == 'Chevrolet') echo "selected='selected'"; ?>>Chevrolet</option>
                    <option value="21" <?php if ($reg['marca'] == 'Fiat') echo "selected='selected'"; ?>>Fiat</option>
                    <option value="22" <?php if ($reg['marca'] == 'Ford') echo "selected='selected'"; ?>>Ford</option>
                    <option value="25" <?php if ($reg['marca'] == 'Honda') echo "selected='selected'"; ?>>Honda</option>
                    <option value="26" <?php if ($reg['marca'] == 'Hyundai') echo "selected='selected'"; ?>>Hyundai</option>
                    <option value="29" <?php if ($reg['marca'] == 'Jeep') echo "selected='selected'"; ?>>Jeep</option>
                    <option value="31" <?php if ($reg['marca'] == 'Kia') echo "selected='selected'"; ?>>Kia</option>
                    <option value="33" <?php if ($reg['marca'] == 'Land Rover') echo "selected='selected'"; ?>>Land Rover</option>
                    <option value="39" <?php if ($reg['marca'] == 'Mercedes-Benz') echo "selected='selected'"; ?>>Mercedes-Benz</option>
                    <option value="43" <?php if ($reg['marca'] == 'Nissan') echo "selected='selected'"; ?>>Nissan</option>
                    <option value="44" <?php if ($reg['marca'] == 'Peugeot') echo "selected='selected'"; ?>>Peugeot</option>
                    <option value="48" <?php if ($reg['marca'] == 'Renault') echo "selected='selected'"; ?>>Renault</option>
                    <option value="55" <?php if ($reg['marca'] == 'Suzuki') echo "selected='selected'"; ?>>Suzuki</option>
                    <option value="56" <?php if ($reg['marca'] == 'Toyota') echo "selected='selected'"; ?>>Toyota</option>
                    <option value="59" <?php if ($reg['marca'] == 'VolksWagen') echo "selected='selected'"; ?>>VolksWagen</option>
                    <option value="58" <?php if ($reg['marca'] == 'Volvo') echo "selected='selected'"; ?>>Volvo</option>
                    <option value="177" <?php if ($reg['marca'] == 'Jac Motors') echo "selected='selected'"; ?>>Jac Motors</option>
                    <option value="outros">Outros</option>
                </select>                         
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-4 col-md-6 col-xs-12 text-center input-none" id="idmarca">
                    <label for="">Marca:</label>                    
                    <div id="input-marca">
                    </div>
                </div>
                <input type="hidden" name="marca" value="" id="name-marca">

                <div class="col-lg-4 col-md-6 col-xs-12 text-center" id="idmodel">
                    <label for="">Modelo:</label>                    
                    <div id="input-modelo">
                    <input type="text" required id="inputModelo" value="<?php echo $reg['modelo']; ?>" placeholder="Titan, JET 50, SUN 150">
                    </div>
                    <select id="modelo" class="input-none">
                    </select>
                </div>
                <input type="hidden" name="modelo" value="okokk" id="name-modelo">
                <div class="col-lg-4 text-center">
                    <label for="">Cor:</label><br>
                    <select name="cor" id="cor" required>
                        <option value="Branco">Branco</option>
                        <option value="Azul">Azul</option>
                        <option value="Preto">Preto</option>
                        <option value="Vermelho">Vermelho</option>
                        <option value="Amarelo">Amarelo/Dourado</option>
                        <option value="Cinza">Cinza</option>
                        <option value="Verde">Verde</option>
                        <option value="Laranja">Laranja</option>
                        <option value="Marrom">Marrom</option>
                        <option value="Prata">Prata</option>
                        <option value="Bege">Bege</option>
                    </select>
                </div>
                <div class="col-lg-4 text-center mt-4">
                    <button class="btn btn-primary" id="cad" type="submit">Alterar</button>
                </div>
                    <input type="hidden" name="id_veiculo" value="<?php echo $id ?>">
                    <input type="hidden" name="tabela" value="formAlterVeiculo">
                <?php
                    }
                ?>
            </div>
        </form> 
    </div>
        <?php
		    require_once "../../lib/dep-script.php";
	    ?>
        <script src="public/js/script-search-car.js"></script>
    </body>
</html>