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
    <title>Opções financeiras</title>
    <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
    <link rel="stylesheet" href="app/view/style/page-finance.css">
</head>
<body>
    <?php    
        require_once "menu.php";
    ?>
    <div class="container-customized">
        <section class="option-finance">
            <form action="" method="POST" id="search-finance" onsubmit="valid(this); return true;">
                <div class="select-block">
                <label for="gerar_boleto">Consultar Pagamentos</label>
                    <div>
                        <a href="consultar-financeiro" class="btn btn-primary"><img src="public/img/money.png" alt="Money"></a>
                    </div>
                </div>
                <div class="select-block">
                    <label for="gerar_boleto">Gerar Boleto</label>
                    <div>
                        <a href="gerar-boleto" class="btn btn-primary"><img src="public/img/document.png" alt="Gerar Boleto"></a>
                    </div>
                </div>
                <div class="select-block">
                    <label for="historico">Resulmo Financeiro</label>
                    <div>
                        <a href="resulmo-financeiro" class="btn btn-primary"><img src="public/img/resulmo-finance.png" alt="Gerar Boleto"></a>
                    </div>
                </div>
               </form>
        </section>
        </main>
    </div>
    <?php
		require_once "../../lib/dep-script.php";
	?>
</body>
</html>