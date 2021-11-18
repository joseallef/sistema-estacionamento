<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();
    if($token->checkAuth()){}else{header("Location: index.php");}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resulmo Financeiro</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/>
    <link rel="stylesheet" href="app/view/style/page-finance.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <?php
        require_once "menu.php";
        use AppC\Financeiro;
        $financeiro = new Financeiro();
    ?>
    <div class="container-customized">
        <section class="option-finance">
            <form action="" method="POST" id="search-finance" onsubmit="valid(this); return true;">
                <div class="select-block">
                    <label for="gerar_boleto">Data Inicio</label>
                    <input type="date" name="data_inicio" required>
                </div>
                <div class="select-block">
                    <label for="historico">Data Fim</label>
                    <input type="date" name="data_fim" required>
                </div>
                <div class="select-block">
                    <input type="submit" class="button" id="btn-pesquisar" value="Pesquisar">
                    <input type="hidden" name="numeroPagina" id="numeroPagina" value="">
                </div>
               </form>
        </section>
        <?php if(isset($_POST['data_inicio']))
            {
                $response = $financeiro->resulmoFinanceiro($_POST['data_inicio'], $_POST['data_fim']);
                foreach($response as $value)
                {
                    if($value)
                    {
                        foreach($value as $data)
                        {
                            if(isset($data['valor']))
                            {
                                $array[] = $data['valor'];
                            }
                        }
                    }
                }
        ?>
        <main class="resulmo_financeiro">
                <input type="hidden" name="recebido" class="recebido" value="<?php echo $array[0]; ?>">
                <input type="hidden" name="previsto" class="previsto" value="<?php echo $array[1]; ?>">
                <input type="hidden" name="baixados" class="baixados" value="<?php echo $array[2]; ?>">
                <input type="hidden" name="expirados" class="expirados" value="<?php echo $array[3]; ?>">            
                <div class="scroll-grafic">      
                    <div id="resulmo_financeiro">
                        
                    </div>                
                </div>
                <div class="scroll-grafic">
                    <div id="grafic_column">

                    </div>
                </div>
        </main>
        <?php 
            }
        ?>
    </div>
    <?php
		require_once "../../lib/dep-script.php";
	?>
</body>
</html>