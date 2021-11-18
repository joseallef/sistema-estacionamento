<?php

namespace AppC;

session_start();
require_once "../../vendor/autoload.php";
require_once "../../src/db/Conection.php";

use SrcD\Conection;
use AppC\Token;

class Login extends Conection
{
    public function __construct()
    {
        if (!isset($_POST['usuario']) || empty($_POST['senha'])) {
            header('Location: index.php');
            echo "<script> window.location.href='index.php';</script>";
            exit();
        } else {
            self::connect();
        }
    }
    public function connect()
    {
        $senha = md5($_POST['senha']);
        $usu = $_POST['usuario'];
        $stmt = $this->conectionDB()->prepare("SELECT usuario FROM usuario WHERE usuario = '$usu' and senha = '$senha'");
        $stmt->execute();

        $row = $stmt->rowCount();


        // Login index
        if ($_POST['pass'] == "autentico") {
            if ($stmt->rowCount() == 1) {
                $token = new Token();
                $token->login(session_id());
                header('Location: opcoes-clientes');
                exit();
            } else {
                setcookie('nao_autenticado', true, time() + 1);
                echo "<script> window.location.href='index.php';</script>";
                header('Location: index.php');
                exit();
            }
        } else {
            setcookie('nao_autenticado', true, time() + 1);
            echo "<script> window.location.href='index.php';</script>";
            header('Location: index.php');
        }
    }
}
new Login();
