<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();   
    if($token->checkAuth()){}else{header("Location: index.php");}
    
    require_once "../model/GeraContrato.php";
    require_once "../controllers/Criptor.php";
    date_default_timezone_set("America/Sao_Paulo");    
    $data = date("d/M/Y");
    $dia = date("d");
    $mes = date("m");
    $ano = date("Y");

    use AppM\GeraContrato;
    $dadosContrato = new GeraContrato(); 
    use AppC\Criptor;
    $criptor = new Criptor;
    $id = $criptor->base64($_GET['v'], 2);

    foreach($dadosContrato->extractData($id) as $row)
    {
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $rua = $row['rua'];
        $numero = $row['numero'];
        $comp = $row['complemento'];
        $marca = $row['marca'];
        $modelo = $row['modelo'];
        $cor = $row['cor'];
        $placa = $row['placa'];
        $valor = $row['valor'];
        $venc = $row['vencimento'];
    }

    require_once '../../lib/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    $dompdf = new DOMPDF(["enable_remote" => true]);
    
    $dompdf->load_html('
        <html>
        <link rel="stylesheet" type="text/css" href="style/contrato.css">
        <center><h3>CONTRATO DE PRESTAÇÃO DE SERVIÇO DE ESTACIONAMENTO</h3></center>
        <br><br>
        Pelo presente instrumento, de um lado a <strong>ESTACIONAMENTO TIBURCIO</strong> inscrita no <b>CNPJ</b>
        sob o <b>nº 31.054.716/0001-03,</b> com sede na <b>AV. TIBURCIO DE SOUSA nº 3401, FERRAZ DE VASCONCELOS  - SP,</b>
         doravante denominada simplesmente<strong> CONTRATADA</strong> e de outro lado <strong>'.$nome.'</strong>
         com sede na<strong> '.$rua. ' Nº '.$numero.'</strong>
        <strong>'.$comp.' </strong>inscrita no <b>CPF/CNPJ</b> sob o nº <strong> '.$cpf.'</strong> doravante denominada simplesmente CONTRATANTE, ambas neste ato legalmente representadas,
        têm entre se certo e ajustado que segue:<br>
        1. OBJETO 1.1. O Presente contrato tem por objetivo a contratação de 1 (uma) vaga para veiculo,  
        Marca:<strong> '.$marca.'  ,</strong> Modelo: <strong>'.$modelo.',</strong> Cor: <strong>'.$cor.'</strong> Placa:<strong> '.$placa.'</strong>
        no estacionamento da CONTRATADA sito à AV. TIBURCIO DE SOUSA nº 3401 no período de segunda a domingo, 24h. 
        2. PRAZO  E FIDELIDADE:<br>
        2.1. O presente contrato é válido por prazo de 6 meses(cento e oitenta dias), sendo o termo inicial na assinatura deste.<br>
        2.2. O contrato poderá ser rescindido, por qualquer das partes, que comprove mudança de endereço, perda de trabalho, entrega do imóvel ou morte
        com aviso prévio de 30 dias.<br>
        2.3 A rescisão do contrato acarreta em multa de 10% do valor do contrato. O contrato se renovará
        automaticamente se nem uma das partes se manifestarem com 30 dias de antecedência.<br>
        3. PREÇO E CONDIÇÕES DE PAGAMENTO<br>
        3.1. O valor para o presente contrato é de R$<strong> '.$valor.'</strong> por <strong>1 (uma)</strong> vaga(s)/mês.<br>
        3.2. O valor previsto será reajustado (a ser negociado). Horario: Chegada___:___ Saida: ___:____<br>
        3.3.O pagamento será feito até o dia <strong>'.$venc.'</strong> de cada mês,<strong> Sendo a 1º no ato da assinatura</strong> como forma de deposito, as seguintes serão via boleto.<br>
        3.4. No preço mencionado no item 3.1. Supra, estão incluídas todas as despesas necessárias à prestação dos serviços objeto deste Contrato.<br>
        3.6. O não pagamento de qualquer uma das parcelas previstas neste contrato até o seu respectivo vencimento, acarretará acréscimo ao principal<br>
        da parcela de multa moratória de 2% (dois por cento), mais juros de mora, calculados a razão de 1% (um por cento) ao mês. 
        4. SEGURO RESPONSABILIDADE CIVIL GARAGISTA
        4.1. A CONTRATADA deverá manter apólice de seguro do tipo responsabilidade civil garagista, modalidade guarda de veículos de terceiros,
        no valor de R$200.000,00 observando-se:<br>
        4.2. A responsabilidade abrange o veículo e seus acessórios fixos contra furto ou incêndio. .  A contratante pode a qualquer
        momento exigir uma copia da apólice de seguro vigente da contratada.  A contratante conduzirá o seu próprio veículo e ficará 
        em posse das chaves, a responsabilidade Não será <strong>estendida</strong> à colisão.<br>
        4.3. Exclui-se da cobertura do seguro a locação de automóvel reserva pela CONTRATADA, em caso de furto ou incêndio, durante o
        período de reparo do veículo sinistrado.<br>
        4.4. Veiculos fora do estacionamento na ocasião de eventual sinistro, não estarão cobertos pelo seguro.<br>
        4.5. <strong>O estacionamento não dispõe de manobrista.</strong><br>
        4.6 Em uma eventual colisão, o Estacionamento limita-se a fornecer a parte interessada:  dados, documentos e filmagem, não tendo maior responsabilidade sobre o evento.<br>
        4.7 Diante dessas informações a contratante concorda em fornecer seus dados a parte interessada em uma eventual <strong>colisão.</strong><br>
        4.8 O estacionamento, através  da seguradora  limita-se somente a cobertura de roubo/ furto e ou incêndio.<br>
        5. OBRIGAÇÕES DA CONTRATANTE 5.1. Para estacionamento de motocicleta, fica sendo obrigatório o uso de corrente e cadeado de propriedade do usuário,
        transpassada pela roda dianteira ou traseira, presa ao local destinado para este fim.<br>
        5.2. Respeitar as normas de utilização do estacionamento.<br>
        DISPOSIÇÕES GERAIS: 6.1. Fica acordado entre as partes ora contratantes, que os empregados, associados ou sócios de cada uma das partes não têm
        qualquer vínculo empregatício com a outra parte, cabendo a cada um dos signatários deste contrato, a responsabilidade única e exclusiva pelo
        recolhimento dos encargos trabalhistas e previdenciários dos seus respectivos empregados e/ou terceiros contratados.<br>
        6.2. O presente contrato também poderá ser rescindido, independentemente de qualquer notificação judicial ou extrajudicial, por qualquer das partes, nas seguintes hipóteses:<br>
        6.2.1. Por motivo de força maior, conforme previsto no Código Civil Brasileiro;<br>
        6.2.2. Falsidade de uma das partes nas declarações contidas neste Contrato;<br>
        6.2.3. Interrupção ou paralisação injustificada dos serviços, objeto do presente instrumento, pela CONTRADADA, por qualquer período.<br>
        7. O presente Contrato não implica a constituição de nenhum tipo de sociedade entre a CONTRATADA e a CONTRATANTE.<br>
        7.1. Caso qualquer disposição do presente Contrato seja considerada nula, ilegal ou inexplicável, as partes deverão negociar de boa fé,
        de forma a chegar a um acordo na redação de uma nova cláusula que seja satisfatória a qual reflita suas intenções, conforme expressas
        no presente Contrato, a qual substituirá aquela considerada nula, ilegal ou inexplicável.<br>
        7.2. Qualquer modificação ou aditamento ao presente contrato deverá ser feito por escrito e firmado pelos representantes legais
        de cada parte. Fica eleito o Foro Central do Estado de São Paulo, para dirimir todas e quaisquer dúvidas decorrentes deste contrato de
        locação, com expressa renúncia de qualquer outro, por mais privilegiado que seja ou venha a ser.  E por estarem assim, justas e contratadas,
        firmam as partes o presente instrumento em 02 (duas) vias de igual teor e forma, na presença das testemunhas que o subscrevem. 
        São Paulo,<strong> '.$dia.' / '.$mes.' / '.$ano.' </strong>_______________________________________ CONTRATADA ________________________________________ CONTRATANTE(dono do carro)</html>
  ');
    $dompdf->setPaper("A4");
    $dompdf->render();

    $dompdf->stream(
        "contrato.php",
        array(
            "Attachment" => false
        )
    );

?>