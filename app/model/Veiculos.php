<?php
    namespace AppM;   
    require_once "../../app/controllers/Criptor.php";
    use SrcD\Conection;
    use AppM\ModelVeiculo;
    use AppC\Criptor;
    use FontLib\Table\Type\head;
    use PDO;
    use PDOException;

class Veiculos extends Conection
    {
        public function create(ModelVeiculo $veiculo)
        {
            $criptor = new Criptor();

            try{
                $conn = $this->conectionDB();
                $conn->beginTransaction();
                $stmt = $conn->prepare("INSERT INTO veiculos (placa, modelo, ano, cor, marca, estado, seguro, situacao, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindValue(1, $veiculo->getPlaca());
                $stmt->bindValue(2, $veiculo->getModelo());
                $stmt->bindValue(3, $veiculo->getAno());
                $stmt->bindValue(4, $veiculo->getCor());
                $stmt->bindValue(5, $veiculo->getMarca());
                $stmt->bindValue(6, $veiculo->getEstado());
                $stmt->bindValue(7, $veiculo->getSeguro());
                $stmt->bindValue(8, 'A'); 
                $stmt->bindValue(9, $veiculo->getId());        
                $stmt->execute();
                
                $id_veiculo = $conn->lastInsertId();
                $conn->commit();

                header("Location: cadastro-financeiro?v=".$criptor->base64($id_veiculo, 1));
            }catch(PDOException $e){
                echo "Error ".$e->getMessage();
                $conn->rollBack();
            }
        }

        public function createJoinClientVehicle($id_cliente, $id_veiculo)
        {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO clientes_veiculos (id_cliente, id_veiculo) VALUES (?, ?)");
            $stmt->bindValue(1, $id_cliente);
            $stmt->bindValue(2, $id_veiculo);
            $stmt->execute();
            $conn->commit();
            if(!$stmt){$conn->rollBack();}
        }
        
        // Seleciona os dados de um veiculo da lista para alterar 
        public function selectAlter($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT v.id, v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro, c.nome FROM veiculos v INNER JOIN clientes c ON v.id_cliente = c.id WHERE v.id = $id");
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

        public function listAll()
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, v.id, v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE v.situacao = 'A' AND c.situacao = 'A' ORDER BY c.nome");
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
        // busca um carro pela placa
        public function searchBoard($placa)
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, v.id, v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE placa = '$placa' AND v.situacao = 'A'
            AND c.situacao = 'A'");
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

        public function update(ModelVeiculo $veiculo)
        {
            $criptor = new Criptor;
            $stmt = $this->conectionDB()->prepare("UPDATE veiculos SET  placa= ?, modelo = ?,
            cor = ?, ano = ?, marca = ?, estado = ?, seguro = ? WHERE id = ?");
            $stmt->bindValue(1, $veiculo->getPlaca());
            $stmt->bindValue(2, $veiculo->getModelo());
            $stmt->bindValue(3, $veiculo->getCor());
            $stmt->bindValue(4, $veiculo->getAno());
            $stmt->bindValue(5, $veiculo->getMarca());
            $stmt->bindValue(6, $veiculo->getEstado());
            $stmt->bindValue(7, $veiculo->getSeguro());
            $stmt->bindValue(8, $veiculo->getId());
            $stmt->execute();
        }
        
        public function delete($id)
        {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE veiculos SET situacao = 'I' WHERE id = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $conn->commit();
        }

        public function selectNameResCar($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE id = $id");
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
        public function selectCarsFormerClients($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT v.placa, v.modelo, v.ano, v.cor, v.marca, v.estado, v.seguro, c.situacao FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente INNER JOIN ex_clientes ex ON ex.id_cliente = c.id WHERE c.situacao = 'I' AND c.id = '$id'");
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