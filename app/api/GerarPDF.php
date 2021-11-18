<?php 
    namespace Api;

    require_once "../../vendor/autoload.php";

class GerarPDF 
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
    

    function geraPdf(string $clientName, string $nossoNumero) : string
    {
        $url = "https://apis.bancointer.com.br/openbanking/v1/certificado/boletos/{$nossoNumero}/pdf";
        
        $http_params=array(
            'accept: application/pdf',
        );
       

        $reply = $this->controllerGet($url, $http_params);
        $nomeBoleto = $clientName."-".$nossoNumero;

        $filename = "../api/boleto/".$nomeBoleto.".pdf";

        if (!file_put_contents($filename, base64_decode($reply->body))) {
            throw new BancoInterException("Erro decodificando e salvando PDF", 0, $reply);
        }
        header("Location: app/api/boleto/{$nomeBoleto}.pdf");
        return "";
    }

    public function controllerGet(string $url, array $http_params = null)
    {
        
        if ($http_params == null) {
            $http_params=array(
                'accept: application/json',
            );
        }
        
        $retry = 5;
        while ($retry>0) {
            $this->controllerInit($http_params);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
            
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
                sleep(5);
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
}
