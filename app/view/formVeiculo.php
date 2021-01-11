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
        require "../../vendor/autoload.php";
        require_once "menu.php";
        use AppC\Criptor;
        use AppC\Veiculo;
        $criptor = new Criptor();
        $veiculo = new Veiculo;
    ?>
    <div class="containe">
        <form action="cadastrar-Veiculo" method="POST" enctype="multpart/form-data" class="form">
            <div class="text text-center ">            
                <div class="row ml-12">
                    <?php
                        foreach($veiculo->exibeNomeResposavelCarro($criptor->base64($_GET['v'], 2)) as $reg)
                        {
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Nome do Responsavel</label>
                        <input type="text" name="nomeRes" style="background: #EEEEEE;" value="<?php echo $reg['nome'] ?>" readonly="">
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label for="">Placa:</label>
                    <input type="text" name="placa" id="placa" required="" placeholder="AAA-0000">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label for="">Modelo:</label>
                    <input type="text" name="modelo" id="modelo" required="" placeholder="GOL, PALIO, UNO">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label for="">Ano:</label>
                    <input type="text" name="ano" id="ano" required="" placeholder="2010">
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
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
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Marca:</label><br>
                    <select name="marca" id="marca" required>
                        <option value="Audi">Audi</option>
                        <option value="Bentley">Bentley</option>
                        <option value="BMW">BMW</option>
                        <option value="Chery">Chery</option>
                        <option value="Chevrolet">Chevrolet</option>
                        <option value="Ferrari">Ferrari</option>
                        <option value="Fiat">Fiat</option>
                        <option value="Ford">Ford</option>
                        <option value="Honda">Honda</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Jaguar">Jaguar</option>
                        <option value="Jeep">Jeep</option>
                        <option value="Kia">Kia</option>
                        <option value="Lamborghini">Lamborghini</option>
                        <option value="Land Rover">Land Rover</option>
                        <option value="Lexus">Lexus</option>
                        <option value="Lifan">Lifan</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Mini">Mini</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Porsche">Porsche</option>
                        <option value="Renault">Renault</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Toyota">Toyota</option>
                        <option value="VolksWagen">VolksWagen</option>
                        <option value="Volvo">Volvo</option>
                        <option value="Avelloz">Avelloz </option>
                        <option value="BMW ">BMW </option>
                        <option value="Bravax">Bravax </option>
                        <option value="BRP Bull">BRP Bull </option>
                        <option value="Dafra">Dafra </option>
                        <option value="Dayang">Dayang </option>
                        <option value="Ducati">Ducati </option>
                        <option value="Harley-Davidson">Harley-Davidson </option>
                        <option value="Honda">Honda </option>
                        <option value="Indian">Indian </option>
                        <option value="Iros">Iros </option>
                        <option value="Jonny">Jonny </option>
                        <option value="Kasinski">Kasinski </option>
                        <option value="Kawasaki">Kawasaki </option>
                        <option value="KTM">KTM </option>
                        <option value="Motocar">Motocar </option>
                        <option value="MV Agusta ">MV Agusta </option>
                        <option value="Piaggio">Piaggio </option>
                        <option value="Shineray">Shineray </option>
                        <option value="Suzuki">Suzuki </option>
                        <option value="Traxx">Traxx </option>
                        <option value="Triumph">Triumph </option>
                        <option value="Vespa">Vespa </option>
                        <option value="Wuyang">Wuyang </option>
                        <option value="Yamaha">Yamaha</option>
                    </select><br>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Estado (Placa):</label>          
                    <select name="estado" id="estado" required> 
                        <option value="ac" checked>Acre</option> 
                        <option value="al">Alagoas</option> 
                        <option value="am">Amazonas</option> 
                        <option value="ap">Amapá</option> 
                        <option value="ba">Bahia</option> 
                        <option value="ce">Ceará</option> 
                        <option value="df">Distrito Federal</option> 
                        <option value="es">Esperito Santo</option> 
                        <option value="go">Goiás</option> 
                        <option value="ma">Maranhão</option> 
                        <option value="mt">Mato Grosso</option> 
                        <option value="ms">Mato Grosso do Sul</option> 
                        <option value="mg">Minas Gerais</option> 
                        <option value="pa">Pará</option> 
                        <option value="pb">Paraibá</option>
                        <option value="pr">Paraná</option> 
                        <option value="pe">Pernambuco</option> 
                        <option value="pi">Piauí</option> 
                        <option value="rj">Rio de Janeiro</option> 
                        <option value="rn">Rio Grande do Norte</option> 
                        <option value="ro">Rondônia</option> 
                        <option value="rs">Rio Grande do Sul</option> 
                        <option value="rr">Roraima</option> 
                        <option value="sc">Santa Catarina</option> 
                        <option value="se">Sergipe</option> 
                        <option value="sp">São Paulo</option> 
                        <option value="to">Tocantins</option> 
                    </select></br>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Seguro:</label>
                    <input type="text" name="seguro" placeholder="Azul Seguros, Alto Seguros" required="">
                </div>                
                <input type="hidden" name="id_cliente" value="<?php echo $criptor->base64($_GET['v'], 2); ?>">
                <input type="hidden" name="tabela" value="formVeiculo">
            </div>
            <div class="text-right align-text-bottom">
                <button class="btn btn-primary" type="submit">Cadastrar</button>
            </div>
        </form>
    </div>
    <?php
		require_once "../../lib/dep-script.php";
	?>     
</body>
</html>