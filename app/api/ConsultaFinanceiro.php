<?php
    namespace Api;
    
    require_once "../../vendor/autoload.php";

class ConsultaFinanceiro
{ 
    function consultaSituacaoFinanceira($filtarPor, $data_inicio, $data_fim, $numPag)
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();
        $parametros=array(
        'accept: application/json',
        'x-inter-conta-corrente: '.getenv('ACCOUNT'));

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // Primeira opção
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // Segunda opção
        curl_setopt($ch, CURLOPT_URL, "https://apis.bancointer.com.br/openbanking/v1/certificado/boletos?filtrarPor={$filtarPor}&filtrarDataPor=SITUACAO&dataInicial={$data_inicio}&dataFinal={$data_fim}&ordenarPor=NOMESACADO&page={$numPag}&size=20");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, CERTIFIED);
        curl_setopt($ch, CURLOPT_SSLKEY, CERTIFIED_KEY);
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, getenv('PASSWORD'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER,$parametros);

        $headers = array();
        $headers[] = 'X-Inter-Conta-Corrente: '.getenv('ACCOUNT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result, true);
        
        return $response;
    }
}