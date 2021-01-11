<?php
    namespace AppM;

use PDO;
use SrcD\Conection;
use AppM\ModelCliente;
use AppC\Criptor;

class Clientes extends Conection
    {
        public function create($cliente)
        {
            $sql = ("INSERT INTO clientes (nome, email, data, cpf, sexo, estCivil, cep,
            estado, cidade, bairro, rua, numero, complemento, telMovel, telFixo, foto, data_entrada, situacao) VALUES 
            (:nome, :email, :data, :cpf, :sexo, :estadoC, :cep, :estado, :cidade, :bairro, :rua, :numero, :compl, :telM, :telF, :foto, :data_entrada, :situacao)");
            $stmt = $this->conectionDB()->prepare($sql);
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':email', $cliente->getEmail());
            $stmt->bindValue(':data', $cliente->getData());
            $stmt->bindValue(':cpf', $cliente->getCpf());
            $stmt->bindValue(':sexo', $cliente->getSexo());
            $stmt->bindValue(':estadoC', $cliente->getEstadoCivil());
            $stmt->bindValue(':cep', $cliente->getCep());
            $stmt->bindValue(':estado', $cliente->getEstado());
            $stmt->bindValue(':cidade', $cliente->getCidade());
            $stmt->bindValue(':bairro', $cliente->getBairro());
            $stmt->bindValue(':rua', $cliente->getRua());
            $stmt->bindValue(':numero', $cliente->getNumero());
            $stmt->bindValue(':compl', $cliente->getComplemento());
            $stmt->bindValue(':telM', $cliente->getTelMovel());
            $stmt->bindValue(':telF', $cliente->getTelFixo());
            $stmt->bindValue(':foto', $cliente->getFile());
            $stmt->bindValue(':data_entrada', date("Y-m-d"));
            $stmt->bindValue(':situacao', 'A');
            $stmt->execute();
        }

        public function update($cliente)
        {
            $criptor = new Criptor;
            $sql = ("UPDATE clientes SET nome = ?, email = ?, data = ?, cpf = ?, sexo = ?, estcivil = ?, cep = ?, estado = ?, cidade = ?, bairro = ?, rua = ?, numero = ?, complemento = ?, telmovel = ?, telfixo = ?,
              foto = ? WHERE id = ?");
            $stmt = $this->conectionDB()->prepare($sql);
            $stmt->bindValue(1, $cliente->getNome());
            $stmt->bindValue(2, $cliente->getEmail());
            $stmt->bindValue(3, $cliente->getData());
            $stmt->bindValue(4, $cliente->getCpf());
            $stmt->bindValue(5, $cliente->getSexo());
            $stmt->bindValue(6, $cliente->getEstadoCivil());
            $stmt->bindValue(7, $cliente->getCep());
            $stmt->bindValue(8, $cliente->getEstado());
            $stmt->bindValue(9, $cliente->getCidade());
            $stmt->bindValue(10, $cliente->getBairro());
            $stmt->bindValue(11, $cliente->getRua());
            $stmt->bindValue(12, $cliente->getNumero());
            $stmt->bindValue(13, $cliente->getComplemento());
            $stmt->bindValue(14, $cliente->getTelMovel());
            $stmt->bindValue(15, $cliente->getTelFixo());
            $stmt->bindValue(16, $cliente->getFile());
            $stmt->bindValue(17, $cliente->getId());

            $stmt->execute();
            header("Location: mais-dados-clientes?v=".$criptor->base64($cliente->getId(), 1));
        }


        public function listAll()
        {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' ORDER BY nome");
            $stmt->execute();
            $cliente = new ModelCliente;
            if($stmt->rowCount() > 0)
            {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
                {        
                    $array[] = $row;

                }      
                return $array;
            }else
                return "";
        }
        // faz a busca por nome
        public function listId($nome_cpf_cnpj)
        {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' AND nome LIKE '%$nome_cpf_cnpj%'
             OR cpf LIKE '%$nome_cpf_cnpj%' LIMIT 5");
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
                {
                    $array[] = $row;
                }
                return $array;
            }
            return "";
        }
        
        // lista todos os dados de um cliente 
        public function listAllClientId($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' AND id = $id");
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

        // Retorna o nome e id com base na tabela cliente e veiculo para gerar o contrato se aver carro
        function returnNameBaseClintCar($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE v.situacao = 'A' AND c.id = '$id'");
            $stmt->execute();
            if($stmt->rowCount())
            {
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
                {
                    $array[] = $row;
                }
                return $array;
            }
        }

        function financialDataAllList()
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, f.id, f.vencimento, f.valor, f.numboleto FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
            AND v.situacao = 'A' ORDER BY c.nome");
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

        function listFinancialDataByDate($expiration)
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, f.id, f.vencimento, f.valor, f.numboleto FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
            AND v.situacao = 'A' AND f.vencimento = '$expiration'");
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

        function listFinancialDataById($id)
        {
            $stmt = $this->conectionDB()->prepare("SELECT f.vencimento, f.valor FROM veiculos v INNER JOIN financeiro f ON f.id_veiculo = v.id WHERE f.id = '$id'");
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

        function listFinancialDataByName($name)
        {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, f.id, f.vencimento, f.valor, f.numboleto FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
            AND v.situacao = 'A' AND c.nome LIKE '%$name%' ORDER BY c.nome LIMIT 8");
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

        public function delete($id, $messag)
        {
            $criptor = new Criptor;
            date_default_timezone_set('America/Sao_Paulo');
            $data_atual = date("Y/m/d");
            $hora_saida = date("H:i:s");
            if($messag != "")
            {
                $stmt = $this->conectionDB()->prepare("UPDATE clientes SET situacao = 'I' WHERE id = '$id'");
                $stmt->execute();

                $stmt = $this->conectionDB()->prepare("INSERT INTO ex_clientes (data_saida, descricao, id_cliente) VALUES (?, ?, ?)");
                $stmt->bindValue(1, $data_atual);
                $stmt->bindValue(2, $messag);
                $stmt->bindValue(3, $id);
                $stmt->execute();

                $stmt = $this->conectionDB()->prepare("UPDATE veiculos SET situacao = 'I' WHERE id = (SELECT c.id FROM clientes c
                INNER JOIN clientes_veiculos d ON c.id = d.id_cliente INNER JOIN veiculos v ON v.id = d.id_veiculo INNER JOIN ex_clientes ex ON ex.id_cliente = c.id WHERE c.situacao = 'I' AND c.id = '$id')");

                $stmt->execute();

                header("Location: clientes");
            }else{
                header("Location: mais-dados-clientes?v=".$criptor->base64($id, 1));
            }
        }
        public function alterStatus($id)
        {
            $stmt = $this->conectionDB()->prepare("UPDATE clientes SET situacao = 'A' WHERE id = '$id'");
            $stmt->execute();
            if($stmt){return true;}else { return false; }
        }
    }