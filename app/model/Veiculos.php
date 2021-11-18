<?php

namespace AppM;

require_once "../../app/controllers/Criptor.php";

use SrcD\Conection;
use AppM\ModelVeiculo;
use PDOException;

class Veiculos extends Conection
{
    public function create(ModelVeiculo $veiculo)
    {
        try {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO veiculos (placa, modelo, cor, marca, situacao, id_cliente) VALUES 
                (?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $veiculo->getPlaca());
            $stmt->bindValue(2, $veiculo->getModelo());
            $stmt->bindValue(3, $veiculo->getCor());
            $stmt->bindValue(4, $veiculo->getMarca());
            $stmt->bindValue(5, 'A');
            $stmt->bindValue(6, $veiculo->getId());
            $stmt->execute();

            $id_veiculo = $conn->lastInsertId();
            $conn->commit();

            return $id_veiculo;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
            $conn->rollBack();
        }
    }

    // Seleciona os dados de um veiculo da lista para alterar 
    public function selectAlter($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT v.id, v.placa, v.modelo, v.cor, v.marca, c.nome FROM veiculos v INNER JOIN clientes c ON v.id_cliente = c.id WHERE v.id = $id");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    public function listAllVehicleActives()
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.nome, v.id, v.placa, v.modelo, v.cor, v.marca FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE v.situacao = 'A' AND c.situacao = 'A' ORDER BY c.nome");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    public function listAllVehicle()
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.nome, v.id, v.placa, v.modelo, v.cor, v.marca, v.situacao FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente ORDER BY c.nome");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }
    // busca um carro pela placa
    public function searchBoard($placa)
    {
        $stmt = $this->conectionDB()->prepare("SELECT c.nome, v.id, v.placa, v.modelo, v.cor, v.marca FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE placa = '$placa' AND v.situacao = 'A'
            AND c.situacao = 'A'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    public function update(ModelVeiculo $veiculo)
    {
        $stmt = $this->conectionDB()->prepare("UPDATE veiculos SET  placa= ?, modelo = ?,
            cor = ?, marca = ? WHERE id = ?");
        $stmt->bindValue(1, $veiculo->getPlaca());
        $stmt->bindValue(2, $veiculo->getModelo());
        $stmt->bindValue(3, $veiculo->getCor());
        $stmt->bindValue(4, $veiculo->getMarca());
        $stmt->bindValue(5, $veiculo->getId());
        return $stmt->execute();
    }

    public function delete($id)
    {
        $conn = $this->conectionDB();
        $conn->beginTransaction();
        $stmt = $conn->prepare("UPDATE veiculos SET situacao = 'I' WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stats = $stmt->execute();
        $conn->commit();
        return $stats;
    }

    public function permanentlyDelete($id)
    {
        $conn = $this->conectionDB();
        $conn->beginTransaction();
        $stmt = $conn->prepare("DELETE FROM veiculos WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stats = $stmt->execute();
        $conn->commit();
        return $stats;
    }

    public function selectNameResCar($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE id = $id");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }
    public function selectCarsFormerClients($id)
    {
        $stmt = $this->conectionDB()->prepare("SELECT v.placa, v.modelo, v.cor, v.marca, c.situacao FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente INNER JOIN ex_clientes ex ON ex.id_cliente = c.id WHERE c.situacao = 'I' AND c.id = '$id'");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    function addVacancies($cont)
    {
        $v_cont = $cont++;
        $stmt = $this->conectionDB()->prepare("INSERT INTO vagas (vaga) VALUES ('V-A$v_cont')");
        $stmt->execute();
    }

    function deleteVacacies($v_cont)
    {
        $stmt = $this->conectionDB()->prepare("DELETE FROM vagas WHERE vaga = 'V-A$v_cont'");
        $stmt->execute();
    }
}
