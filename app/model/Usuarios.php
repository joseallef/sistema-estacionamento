<?php
    namespace AppM;

use PDO;
use PDOException;
use SrcD\Conection;

class Usuarios extends Conection
    {
        function selectUser($user, $password)
        {
            try{
                $conn = $this->conectionDB();
                $conn->beginTransaction();
                $stmt = $conn->prepare("SELECT id, usuario, senha FROM usuario WHERE usuario = '$user' and senha = '$password'");
                $stmt->execute();                
                
                //$id_user = $conn->lastInsertId(); Retorna o ultimo id quando e um insert

                $conn->commit();
                if($stmt->rowCount() == 1)
                {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        return $row['id'];
                    }           
                }
            }catch(PDOException $e){
                echo "Erro ".$e->getMessage();
            }
        }
        function alterUser($user, $password, $newPassword)
        {
            $id_user = $this->selectUser($user, $password);
            if($this->selectUser($user, $password))
            {
                var_dump($user, $password, $newPassword, $id_user);
                $conn = $this->conectionDB();
                $stmt = $conn->prepare("UPDATE usuario SET senha = '$newPassword' WHERE id = '$id_user'");
                $stmt->execute();
                return $stmt;
            }
        }
    }