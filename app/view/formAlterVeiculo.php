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
    <div id="wrapper" class="toggled">
        <div id="page-content-wrapper">
        <div class="containe">
                <form action="update-veiculo" method="POST" enctype="multpart/form-data" class="form">
                    <div class="row text text-center">
                        <div class="row ml-12">
                        <?php
                            $id = $objControl->base64($_GET['v'], 2);
                            foreach($veiculo->selecionaId($id) as $reg)
                            {
                        ?>
                        </div>
                        <div class="col-sm-12">
                            <label>Nome do Responsavel</label>
                            <input type="text" name="nomeRes" style="background: #EEEEEE;" value="<?php echo $reg['nome'] ?>" readonly="">
                        </div>

                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <label for="">Placa:</label>
                            <input type="text" class="col-sm-12 tam form-control" required name="placa" id="placa" value="<?php echo $reg['placa']; ?>" placeholder="AAA-0000">
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Modelo:</label>
                            <input type="text" class="tam form-control" name="modelo" required id="modelo" value="<?php echo $reg['modelo']; ?>" placeholder="GOL, PALIO, UNO">
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Ano:</label>
                            <input type="text" class="tam form-control" name="ano" required id="ano" value="<?php echo $reg['ano']; ?>" placeholder="2010">
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
                            </select><br>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <label>Seguro:</label>
                            <input type="text" name="seguro" class="form-control" value="<?php echo $reg['seguro']; ?>" placeholder="Azul Seguros, Alto Seguros">
                            <input type="hidden" name="id_veiculo" value="<?php echo $id ?>">
                            <input type="hidden" name="tabela" value="formAlterVeiculo">
                        </div>
                        <?php
                            }
                        ?>
                    </div><br>
                    <div class="text-right align-text-bottom">
                        <button class="btn btn-primary" type="submit">Alterar</button>
                    </div>
                </form> 
            </div>
        </div>
        </div>
        <?php
		    require_once "../../lib/dep-script.php";
	    ?>   
    </body>
</html>