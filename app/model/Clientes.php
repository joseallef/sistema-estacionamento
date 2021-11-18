<?php

namespace AppM;

use PDO;
use SrcD\Conection;
use AppM\ModelCliente;
use AppC\Criptor;
use Exception;

class Clientes extends Conection
{
    public function create($cliente)
    {
        try {

            $sql = ("INSERT INTO clientes (nome, email, cpf, cep,
                estado, cidade, bairro, rua, numero, complemento, telmovel, foto, data_entrada, situacao) VALUES 
                (:nome, :email, :cpf, :cep, :estado, :cidade, :bairro, :rua, :numero, :complemento, :telmovel,
                :foto, :data_entrada, :situacao)");
            $stmt = $this->conectionDB()->prepare($sql);
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':email', $cliente->getEmail());
            $stmt->bindValue(':cpf', $cliente->getCpf());
            $stmt->bindValue(':cep', $cliente->getCep());
            $stmt->bindValue(':estado', $cliente->getEstado());
            $stmt->bindValue(':cidade', $cliente->getCidade());
            $stmt->bindValue(':bairro', $cliente->getBairro());
            $stmt->bindValue(':rua', $cliente->getRua());
            $stmt->bindValue(':numero', $cliente->getNumero());
            $stmt->bindValue(':complemento', $cliente->getComplemento());
            $stmt->bindValue(':telmovel', $cliente->getTelMovel());
            $stmt->bindValue(':foto', $cliente->getFile());
            $stmt->bindValue(':data_entrada', date("Y-m-d"));
            $stmt->bindValue(':situacao', 'A');
            $stats = $stmt->execute();

            return $stats;
        } catch (Exception $e) {
            throw new Exception('Error ao cadastrar dados! :(', $e->getMessage());
        }
    }

    public function update($cliente)
    {
        try {

            $criptor = new Criptor;
            $sql = ("UPDATE clientes SET nome = ?, email = ?, cpf = ?, cep = ?, estado = ?, cidade = ?, bairro = ?, rua = ?, numero = ?, complemento = ?, telmovel = ?,
                foto = ? WHERE id = ?");
            $stmt = $this->conectionDB()->prepare($sql);
            $stmt->bindValue(1, $cliente->getNome());
            $stmt->bindValue(2, $cliente->getEmail());
            $stmt->bindValue(3, $cliente->getCpf());
            $stmt->bindValue(4, $cliente->getCep());
            $stmt->bindValue(5, $cliente->getEstado());
            $stmt->bindValue(6, $cliente->getCidade());
            $stmt->bindValue(7, $cliente->getBairro());
            $stmt->bindValue(8, $cliente->getRua());
            $stmt->bindValue(9, $cliente->getNumero());
            $stmt->bindValue(10, $cliente->getComplemento());
            $stmt->bindValue(11, $cliente->getTelMovel());
            $stmt->bindValue(12, $cliente->getFile());
            $stmt->bindValue(13, $cliente->getId());

            $stats = $stmt->execute();
            header("Location: mais-dados-clientes?v=" . $criptor->base64($cliente->getId(), 1));
            return $stats;
        } catch (Exception $e) {
            throw new Exception('Error ao atualizar dados! :(', $e->getMessage());
        }
    }


    public function listAllActive()
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' ORDER BY nome");
            $stats = $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            } else
                return $stats;
        } catch (Exception $e) {
            throw new Exception('Error ao listar dados! :(', $e->getMessage());
        }
    }
    public function listAllInactive()
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'I' ORDER BY nome");
            $stats = $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            } else
                return $stats;
        } catch (Exception $e) {
            throw new Exception('Error ao listar dados! :(', $e->getMessage());
        }
    }
    public function listAll()
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes ORDER BY nome");
            $stats = $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            } else
                return $stats;
        } catch (Exception $e) {
            throw new Exception('Error ao listar dados! :(', $e->getMessage());
        }
    }
    // faz a busca por nome
    public function listId($nome_cpf_cnpj)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' AND nome LIKE '%$nome_cpf_cnpj%'
                OR cpf LIKE '%$nome_cpf_cnpj%' LIMIT 5");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
            return "";
        } catch (Exception $e) {
            throw new Exception('Error ao atualizar dados! :(', $e->getMessage());
        }
    }

    // lista todos os dados de um cliente 
    public function listAllClientId($id)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT * FROM clientes WHERE situacao = 'A' AND id = $id");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao atualizar dados! :(', $e->getMessage());
        }
    }

    // Retorna o nome e id com base na tabela cliente e veiculo para gerar o contrato se aver carro
    function returnNameBaseClintCar($id)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome FROM clientes c INNER JOIN veiculos v ON c.id = v.id_cliente WHERE v.situacao = 'A' AND c.id = '$id'");
            $stmt->execute();
            if ($stmt->rowCount()) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao buscar dados! :(', $e->getMessage());
        }
    }

    function financialDataAllList()
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, c.telmovel, f.id, f.vencimento, f.valor, f.numboleto, f.dt_geracao FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
                AND v.situacao = 'A' ORDER BY c.nome");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao buscar dados! :(', $e->getMessage());
        }
    }

    function listFinancialDataByDate($expiration)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, c.telmovel, f.id, f.vencimento, f.valor, f.numboleto, f.dt_geracao FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
                AND v.situacao = 'A' AND f.vencimento = '$expiration'");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao buscar dados! :(', $e->getMessage());
        }
    }

    function listFinancialDataById($id)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT f.vencimento, f.valor FROM veiculos v INNER JOIN financeiro f ON f.id_veiculo = v.id WHERE f.id = '$id'");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao buscar dados! :(', $e->getMessage());
        }
    }

    function listFinancialDataByName($name)
    {
        try {
            $stmt = $this->conectionDB()->prepare("SELECT c.nome, c.telmovel, f.id, f.vencimento, f.valor, f.numboleto, f.dt_geracao FROM clientes c INNER JOIN financeiro f INNER JOIN veiculos v ON f.id_veiculo = v.id ON c.id = v.id_cliente WHERE c.situacao = 'A'
                AND v.situacao = 'A' AND c.nome LIKE '%$name%' ORDER BY c.nome LIMIT 8");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $array[] = $row;
                }
                return $array;
            }
        } catch (Exception $e) {
            throw new Exception('Error ao buscar dados! :(', $e->getMessage());
        }
    }

    public function delete($id, $messag)
    {
        try {
            $criptor = new Criptor;
            date_default_timezone_set('America/Sao_Paulo');
            $data_atual = date("Y/m/d");
            $hora_saida = date("H:i:s");
            if ($messag != "") {
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
            } else {
                header("Location: mais-dados-clientes?v=" . $criptor->base64($id, 1));
            }
        } catch (Exception $e) {
            throw new Exception('Error delete data! :(', $e->getMessage());
        }
    }
    public function alterStatus($id)
    {
        $stmt = $this->conectionDB()->prepare("UPDATE clientes SET situacao = 'A' WHERE id = '$id'");
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}
