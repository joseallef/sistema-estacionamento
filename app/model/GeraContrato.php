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
        $stmt = $conn->prepare("SELECT c.nome, c.rua, c.cpf, c.numero, c.complemento, v.id, v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro, f.valor, f.vencimento FROM clientes c
        INNER JOIN  clientes_veiculos d ON c.id = d.id_cliente INNER JOIN veiculos v ON v.id = d.id_veiculo INNER JOIN financeiro f ON f.id_cliente = c.id WHERE v.situacao = 'A' AND c.situacao = 'A' AND c.id = '$id'");

         $stmt->execute();

         $conn->commit();

         while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
         {
             $array[] = $row;
         }
         return $array;
    }
}