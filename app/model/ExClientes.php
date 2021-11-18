<?php

namespace AppM;

use PDO;
use SrcD\Conection;

class ExClientes extends Conection
{
    function listAllExClient()
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.id, c.nome, c.cpf, c.cep, c.estado, c.cidade, c.bairro,
            c.rua, c.numero, c.complemento, c.telmovel, c.data_entrada, ex.data_saida FROM clientes c INNER JOIN ex_clientes ex
            ON ex.id_cliente = c.id WHERE c.situacao = 'I'
            ORDER BY ex.data_saida DESC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function listExClientByName($name)
    {
        $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'I' AND nome LIKE '%$name%' LIMIT 2");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }
    function listExClientById($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'I' AND id = $id");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function listExClientByCpf($cpf)
    {
        $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'I' AND cpf LIKE '$cpf%'");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function searchExClientByBoard($placa)
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.nome, c.id, v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro FROM clientes c INNER JOIN  clientes_veiculos d ON c.id = d.id_cliente INNER JOIN veiculos v ON v.id = d.id_veiculo 
            WHERE c.situacao = 'I' AND placa LIKE '$placa%'");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function searchExClientByDate($date_begin, $date_end)
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.nome, c.cpf, c.cep, c.estado, c.cidade, c.bairro, c.rua, c.numero, c.complemento, c.telMovel, c.id, ex.data_saida
            FROM clientes c INNER JOIN ex_clientes ex ON ex.id_cliente = c.id
             WHERE c.situacao = 'I' AND ex.data_saida BETWEEN '$date_begin' AND '$date_end'");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    // Exibe o motivo da saida do cliente, data de entrada e saida
    function listInformationClient($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT * FROM ex_clientes WHERE id_cliente = '$id'");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }
}
