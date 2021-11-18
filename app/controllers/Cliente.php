<?php

namespace AppC;

require_once  '../../vendor/autoload.php';

use AppM\ModelCliente;
use AppM\Clientes;

class Cliente
{

    public function __construct()
    {
        if (isset($_POST['tabela'])) {
            $tableRef = $_POST['tabela'];
            if ($tableRef == 'formAlterCliente') {
                self::alterar();
            } else
                if ($tableRef == 'formClientes') {
                self::cadastrar();
            }
            if ($tableRef == 'alterExCliente') {
                self::alterarSituacao($_POST['id']);
            } elseif ($_POST['tabela'] == 'excluir') {
                self::excluir($_POST['v'], $_POST['assunto']);
            }
        }
    }

    public function validation()
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $cep = $_POST['cep'];
        $estado = $_POST['estado'];
        $cid = $_POST['cid'];
        $bairro = $_POST['bairro'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $com = $_POST['com'];
        $telC = $_POST['telC'];
    }
    public function isImg()
    {
        $extencao = strtolower(substr($_FILES['arquivo']['name'], -4));
        $new_name = time() . $extencao;
        $directory = "../../public/image/";
        if (!empty($_FILES['arquivo']['name'])) {
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $directory . $new_name)) {
                return $new_name;
            }
        } else {
            if (isset($_POST['arq']) && !empty($_POST['arq'])) {
                return $_POST['arq'];
            } else {
                return "avatar.png";
            }
        }
    }

    public function insertion()
    {
        $cliente = new ModelCliente();
        $cliente->setNome($_POST['nome']);
        $cliente->setEmail($_POST['email']);
        $cliente->setCpf($_POST['cpf']);
        $cliente->setCep($_POST['cep']);
        $cliente->setEstado($_POST['estado']);
        $cliente->setCidade($_POST['cid']);
        $cliente->setBairro($_POST['bairro']);
        $cliente->setRua($_POST['rua']);
        $cliente->setNumero($_POST['numero']);
        $cliente->setComplemento($_POST['com']);
        $cliente->setTelMovel($_POST['telC']);
        $cliente->setFile($this->isImg());
        isset($_POST['v']) ? $cliente->setId($_POST['v']) : $cliente->setId('');
        return $cliente;
    }

    public function cadastrar()
    {
        if (empty($this->listarCliente($_POST['cpf']))) {
            $clientes = new Clientes;
            $clientes->create($this->insertion());
            header("Location: clientes?valor=cadSuccess");
        } else {
            header('Location: novo-cliente?valor=Error');
        }
    }

    public function listarTodosDadosFinanceiro()
    {
        $clientes = new Clientes;
        return $clientes->financialDataAllList();
    }

    function listarDadosFinanceiroPorData($vencimento)
    {
        $clientes = new Clientes;
        return $clientes->listFinancialDataByDate($vencimento);
    }

    public function listarDadosFinanceiroPorNome($nome)
    {
        $clientes = new Clientes;
        return $clientes->listFinancialDataByName($nome);
    }

    function listarDadosFinanceiroPorId($id)
    {
        $clientes = new Clientes;
        return $clientes->listFinancialDataById($id);
    }

    public function alterar()
    {
        $clientes = new Clientes;
        return $clientes->update($this->insertion());
    }

    public function listarTodosClientesAtivos()
    {
        $clientes = new Clientes;
        $cliente = new ModelCliente();
        $cliente = $clientes->listAllActive();
        return $cliente;
    }

    public function listarTodosClientesInativos()
    {
        $clientes = new Clientes;
        $cliente = new ModelCliente();
        $cliente = $clientes->listAllInactive();
        return $cliente;
    }

    public function listarTodosClientes()
    {
        $clientes = new Clientes;
        $cliente = new ModelCliente();
        $cliente = $clientes->listAll();
        return $cliente;
    }


    public function listarCliente($name)
    {
        $clientes = new Clientes;
        return $clientes->listId($name);
    }

    public function listarTodosDadosCliente($id)
    {
        $clientes = new Clientes;
        return $clientes->listAllClientId($id);
    }

    public function geraContrato($id)
    {
        $clientes = new Clientes;
        return $clientes->returnNameBaseClintCar($id);
    }

    public function excluir($id, $messag)
    {
        $clientes = new Clientes;
        $clientes->delete($id, $messag);
    }

    public function alterarSituacao($id)
    {
        $clientes = new Clientes;
        $clientes->alterStatus($id);
        header("Location: clientes");
    }
}

new Cliente();
