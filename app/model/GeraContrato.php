<?php
    namespace AppM;

    require_once "../../vendor/autoload.php";

    use SrcD\Conection;

class GeraContrato extends Conection 
{
    function extractData($id)
    {
        $conn = $this->conectionDB();
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT c.nome, c.rua, c.cpf, c.numero, c.complemento, v.id, v.placa, v.modelo, v.cor, v.marca, f.valor, f.vencimento FROM clientes c INNER JOIN veiculos v ON v.id_cliente = c.id INNER JOIN financeiro f ON f.id_veiculo = v.id WHERE v.situacao = 'A' AND c.situacao = 'A' AND c.id = '$id'");

         $stmt->execute();

         $conn->commit();

         while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
         {
             $array[] = $row;
         }
         return $array;
    }
}