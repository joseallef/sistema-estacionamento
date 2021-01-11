<?php
    namespace SrcD;
    require_once  '../../vendor/autoload.php';

use PDO;
use PDOException;

require_once "config.php";


abstract class Conection 
{
    function __construct()
    {
        $this->conectionDB();
    }    
    
    public function conectionDB()
    {
        try
        {
    
            $conn = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD);
            return $conn;

        }catch(\PDOException $erro){
            return "Erro ao conectar".$erro->getMessage();
        }
    }

}
