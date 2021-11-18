<?php

namespace SrcD;

use PDO;
use PDOException;

abstract class Conection
{

    public function conectionDB()
    {
        try {
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $conn = new \PDO("pgsql:host=localhost; port=5432; user='postgres'; password=' '; dbname='estacionamento';");
            } else {
                $conn = new \PDO("pgsql:host=" . getenv('DB_HOST') . "; port=" . getenv('DB_PORT') . "; user=" . getenv('DB_USER') . "; password=" . getenv('DB_PASSWORD') . "; dbname=" . getenv('DB_NAME') . ";");
            }
            return $conn;
        } catch (\PDOException $erro) {
            return "Erro ao conectar" . $erro->getMessage();
        }
    }
}
