<?php 
    namespace AppM;

    require_once "../controllers/Criptor.php";
    use SrcD\Conection;
    use AppM\ModelFinanceiro;
    use AppC\Criptor;
    use PDO;
    use PDOException;

class Financeiros extends Conection
    {
        public function createFinance(ModelFinanceiro $financeiro)
        {
            $criptor = new Criptor;
            try{
                $conn = $this->conectionDB();
                $conn->beginTransaction();
                $stmt = $conn->prepare("INSERT INTO financeiro (valor, vencimento, assunto, numboleto, id_veiculo)
                VALUES (?, ?, ?, ?, ?)");
                $stmt->bindValue(1, $financeiro->getValor());
                $stmt->bindValue(2, $financeiro->getVencimento());
                $stmt->bindValue(3, $financeiro->getAssunto());
                $stmt->bindValue(4, '');
                $stmt->bindValue(5, $criptor->base64($financeiro->getId(), 2));
                $stmt->execute();

                $id_financeiro = $conn->lastInsertId();
                $conn->commit();
            }catch(PDOException $e){
                echo "Error ".$e->getMessage();
                $conn->rollBack();
            }
        }

        public function createExpiration($id_financeiro, $array)
        {
            for($i = 0; $i < 5; $i++)
            {
                $conn = $this->conectionDB();
                $conn->beginTransaction();   
                $stmt = $conn->prepare("INSERT INTO vencimento (dt_vencimento, id_financeiro, status) VALUES (?, ?, ?)");
                $stmt->bindValue(1, $array[$i]);
                $stmt->bindValue(2, $id_financeiro);
                $stmt->bindValue(3, 'A');
                $stmt->execute();
                $conn->commit();
                if(!$stmt){$conn->rollBack();}
                
            }
            
        }

        public function listaAll()
        {
            $stmt = $this->conectionDB()->prepare("SELECT f.valor, f.vencimento, v.status, c.nome, c.id, f.id_cliente FROM financeiro f INNER JOIN clientes c ON c.id = f.id_cliente INNER JOIN vencimento v ON 
            f.id = v.id_financeiro WHERE c.situacao = 'A' AND dt_vencimento = '2020-08-10' ");
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $array[] = $row;
                }
                return $array;
            }
        }

        public function searchName($name)
        {
            $stmt = $this->conectionDB()->prepare("SELECT f.valor, f.vencimento, f.assunto, v.status, c.nome, v.dt_vencimento, f.id_cliente FROM financeiro f INNER JOIN clientes c ON c.id = f.id_cliente INNER JOIN vencimento v ON 
            f.id = v.id_financeiro  WHERE c.situacao = ? AND c.nome LIKE ?");
            $stmt->bindValue(1, "A");
            $stmt->bindValue(2, "%$name%");
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $array[] = $row;
                }
                return $array;
            }  
        }

        public function alterFinance(ModelFinanceiro $financeiro)
        {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE financeiro SET valor = ?, vencimento = ? WHERE id = ?");
            $stmt->bindValue(1, $financeiro->getValor());
             $stmt->bindValue(2, $financeiro->getVencimento());
            $stmt->bindValue(3, $financeiro->getId());
            $stmt->execute();
            $conn->commit();
        }

        public function alterStatusFinance($status, $id)
        {
            if($status == 'A')
            {
                $stmt = $this->conectionDB()->prepare("UPDATE vencimento SET status = 'A' WHERE id_financeiro = (SELECT f.id FROM financeiro f INNER JOIN clientes c ON c.id = f.id_cliente WHERE c.id = $id)");
            }else{
                $stmt = $this->conectionDB()->prepare("UPDATE vencimento SET status = 'P' WHERE id_financeiro = (SELECT f.id FROM financeiro f INNER JOIN clientes c ON c.id = f.id_cliente WHERE c.id = $id)");
            }
            $stmt->execute();
        }

        public function insertNumeroBoleto($numBoleto, $id)
        {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE financeiro SET numboleto = '$numBoleto' WHERE id = '$id'");
            $stmt->execute();
            $conn->commit();
        }
    }