<?php
    namespace Api;

    require_once "../../vendor/autoload.php";

    use AppM\ModelFinanceiro;
    use AppM\ModelCliente;
    use AppM\Financeiros;
    use Api\Boleto;
    use Api\GerarPDF;
    use Api\StdSerializable;

define("INTER_BAIXA_ACERTOS", "ACERTOS");
define("INTER_BAIXA_PROTESTADO", "PROTESTADO");
define("INTER_BAIXA_DEVOLUCAO", "DEVOLUCAO");
define("INTER_BAIXA_SUBSTITUICAO", "SUBISTITUICAO");

define("INTER_FILTRO_TODOS", "TODOS");
define("INTER_FILTRO_VENCIDOSAVENCER", "VENCIDOSAVENCER");
define("INTER_FILTRO_EXPIRADOS", "EXPIRADOS");
define("INTER_FILTRO_PAGOS", "PAGOS");
define("INTER_FILTRO_TODOSBAIXADOS", "TODOSBAIXADOS");

define("INTER_ORDEM_NOSSONUMERO", "NOSSONUMERO");
define("INTER_ORDEM_SEUNUMERO", "SEUNUMERO");
define("INTER_ORDEM_VENCIMENTO", "DATAVENCIMENTO_ASC");
define("INTER_ORDEM_VENCIMENTO_DESC", "DATAVENCIMENTO_DSC");
define("INTER_ORDEM_NOMESACADO", "NOMESACADO");
define("INTER_ORDEM_VALOR", "VALOR_ASC");
define("INTER_ORDEM_VALOR_DESC", "VALOR_DSC");
define("INTER_ORDEM_STATUS", "STATUS_ASC");
define("INTER_ORDEM_STATUS_DESC", "STATUS_DSC");

class GerarBoleto
{
    private $curl = null;

    private function controllerInit(array $http_params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSLCERT, CERTIFIED);
        curl_setopt($curl, CURLOPT_SSLKEY, CERTIFIED_KEY);
        curl_setopt($curl, CURLOPT_KEYPASSWD, getenv('PASSWORD'));
        curl_setopt($curl, CURLOPT_CAPATH, "private/");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');

        $http_params[] = 'x-inter-conta-corrente: '.getenv('ACCOUNT');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $http_params);
        
        $this->curl = $curl;
    }
    
    function geraBoleto(Boleto $boleto, $id) : Boleto
    {
        try{

            $url = "https://apis.bancointer.com.br/openbanking/v1/certificado/boletos";
    
            // garante que o boleto tem um controller
            $boleto->setController($this);
        
            $reply = $this->controllerPost($url, $boleto);
    
            $data = json_decode($reply->body);

            $initialName = explode(' ', $boleto->getPagador()->getNome());
    
    
            $criarPDF = new GerarPDF;
            $financeiro = new Financeiros;
            $financeiro->insertNumeroBoleto($data->nossoNumero, $boleto->getDataVencimento(),  $id);
            $criarPDF->geraPdf($initialName[0]."-".$initialName[1], $data->nossoNumero);
        }catch(\Exception $e){
            header("Location: gerar-boleto?gerarboleto=error");
            throw new \Exception("Erro ao gerar o boleto ".$e);
        }
        return $boleto;
    }

    public function controllerPost(string $url, \JsonSerializable $data, array $http_params = null)
    {

        if ($http_params == null) {
            $http_params=array(
                'accept: application/json',
                'Content-type: application/json'
            );
        }

        $retry = 5;
        while ($retry>0) {
            $this->controllerInit($http_params);
            curl_setopt($this->curl, CURLOPT_URL, $url);
    
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
            
            $curlReply = curl_exec($this->curl);
            if (!$curlReply) {
                $curl_error = curl_error($this->curl);
            }
            $http_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
            curl_close($this->curl);
            $this->curl = null;
    
            $reply = new \stdClass();
            $reply->header = substr($curlReply, 0, $header_size);
            $reply->body = substr($curlReply, $header_size);

            if ($http_code == 503) {
                $retry--;
            } else {
                $retry=0;
            }
        }
        
        if ($http_code == 0) {
            throw new \Exception("Curl error: ".$curl_error);
        }
        
        if ($http_code < 200 || $http_code > 299) {
            throw new BancoInterException("Erro HTTP ".$http_code, $http_code, $reply);
        }
        return $reply;
    }

    function baixarBoleto(string $nossoNumero, string $motivo = 'ACERTOS')
    {
        $data = new StdSerializable();
        $data->codigoBaixa = $motivo;
        try{

            $reply = $this->controllerPost("https://apis.bancointer.com.br:8443/openbanking/v1/certificado/boletos/".$nossoNumero."/baixas", $data);
            
            $replyData = json_decode($reply->body);
            
            // return $replyData;
            var_dump("Resultado da baixa", $replyData);
        }catch(\Exception $e){
            var_dump($data, $reply);
            throw new \Exception("Error ao baixar", $e->getMessage());
        }
        
    }
}