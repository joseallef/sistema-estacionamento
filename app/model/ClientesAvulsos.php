<?php
    namespace AppM;

    use SrcD\Conection;
    date_default_timezone_set('America/Sao_Paulo');
    class ClientesAvulsos extends Conection
    {
        public function create(ModelClienteAvulso $cliente)
        {
            $conn = $this->conectionDB();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO clientes_avulso (nome, rg_cpf, celular, placa, data, hora_entrada, hora_saida) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $cliente->getNome());
            $stmt->bindValue(2, $cliente->getRgCpf());
            $stmt->bindValue(3, $cliente->getTelCelular());
            $stmt->bindValue(4, $cliente->getPlaca());
            $stmt->bindValue(5, date("Y/m/d"));
            $stmt->bindValue(6, date("H:i:s"));
            $stmt->bindValue(7, "");
            $stmt->execute();
            $conn->commit();
            header("Location: clientes-avulso");
        }
        public function exit($id)
        {
            $stmt = $this->conectionDB()->prepare("UPDATE clientes_avulso SET hora_saida = ? WHERE id = ?");
            $stmt->bindValue(1, date("H:i:s"));
            $stmt->bindValue(2, $id);
            $stmt->execute();

            header("Location: clientes-avulso");
        }

        public function list()
        {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes_avulso ORDER BY id DESC");
            $stmt->execute();
            
            if($stmt->rowCount() > 0 )
            {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
                {
                    $array[] = $row;
                }
                return $array;
            }
        }
    }