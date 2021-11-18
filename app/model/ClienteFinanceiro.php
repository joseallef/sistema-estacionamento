<?php
    namespace AppM;

    use SrcD\Conection;

class ClienteFinanceiro extends Conection
{
    function searchData($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.id, c.nome, c.rua, c.numero, c.complemento, c.bairro, c.cidade, c.estado, c.cep, c.cpf, c.email, c.telmovel, f.valor, f.vencimento, f.dt_geracao, v.placa, v.modelo, v.cor, v.marca FROM clientes c INNER JOIN veiculos v ON v.id_cliente = c.id
        INNER JOIN financeiro f ON f.id_veiculo = v.id WHERE f.id = '$id'");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
            {
                $array[] = $row;
            }
            return $array;
        }
    }
}