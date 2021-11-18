<?php
    namespace Api;

class BancoInterException extends \Exception
{

    public $http_code;
    public $reply;
    
    public function __construct($message, $http_code, $reply)
    {
        $this->http_code = $http_code;
        $this->reply = $reply;
        
        parent::__construct($message, null, null);
    }
}
