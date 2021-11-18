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
    <title>Cadastro de Veículos</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
</head>
<body>
    <?php
        require_once "menu.php";
        use AppC\Criptor;
        use AppC\Veiculo;
        $criptor = new Criptor();
        $veiculo = new Veiculo;
    ?>
    <div class="containe">
        <form action="cadastrar-Veiculo" method="POST" enctype="multpart/form-data" class="form">
            <div class="row text-center">
                    <?php
                        foreach($veiculo->exibeNomeResposavelCarro($criptor->base64($_GET['v'], 2)) as $reg)
                        {
                    ?>
                    <div class="col-sm-12">
                        <label>Nome do Responsavel</label>
                        <input type="text" name="nomeRes" style="background: #EEEEEE;" value="<?php echo $reg['nome'] ?>" readonly="">
                    </div>
                    <?php 
                        }
                    ?>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 text-center col-md-12 col-xs-12">
                    <label for="">Placa:</label>
                    <input type="text" name="placa" id="placa" required="" placeholder="AAA-0000">
                </div>
                <div class="col-lg-4 text-center col-md-12 col-xs-12">
                    <label>Marca:</label><br>
                    <select name="marcaCar" id="marca" required>
                        <option value="">Selecione</option>
                        <option value="6">Audi</option>
                        <option value="7">BMW</option>
                        <option value="13">Citroén</option>
                        <option value="161">Chery</option>
                        <option value="23">Chevrolet</option>
                        <option value="21">Fiat</option>
                        <option value="22">Ford</option>
                        <option value="25">Honda</option>
                        <option value="26">Hyundai</option>
                        <option value="29">Jeep</option>
                        <option value="31">Kia</option>
                        <option value="33">Land Rover</option>
                        <option value="39">Mercedes-Benz</option>
                        <option value="41">Mitsubishi</option>
                        <option value="43">Nissan</option>
                        <option value="44">Peugeot</option>
                        <option value="48">Renault</option>
                        <option value="55">Suzuki</option>
                        <option value="56">Toyota</option>
                        <option value="59">VolksWagen</option>
                        <option value="58">Volvo</option>
                        <option value="177">Jac Motors</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-12 col-xs-12 text-center input-none" id="idmarca">
                    <label for="">Marca:</label>                    
                    <div id="input-marca">
                    </div>
                </div>
                <input type="hidden" name="marca" value="" id="name-marca">
            </div>
            <div class="row">                
                <div class="col-lg-4 text-center col-md-6 col-xs-12" id="idmodel">                    
                    <label for="">Modelo:</label>
                    <div id="input-modelo">
                        <!-- <input type="text" name="modelo" placeholder="GOL, PALIO, UNO" required> -->
                    </div>
                    <select id="modelo" require>
                    </select>
                    <input type="hidden" name="modelo" value="" id="name-modelo">
                </div>
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
                    <button class="btn btn-primary" id="cad" type="submit">Cadastrar</button>
                </div>
                <input type="hidden" name="id_cliente" value="<?php echo $criptor->base64($_GET['v'], 2); ?>">
                <input type="hidden" name="tabela" value="formVeiculo">
            </div>
        </form>
    </div>
    <?php
		require_once "../../lib/dep-script.php";
    ?>
    <script src="public/js/script-search-car.js"></script>
</body>
</html>