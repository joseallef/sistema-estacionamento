<?php
    namespace AppC;

    require_once "../../vendor/autoload.php";

    use AppM\ClientesAvulsos;
    use AppM\ModelClienteAvulso;
    class ClienteAvulso
    {
        public function __construct()
        {
            if(isset($_POST['tabela']))
            {
                if($_POST['tabela'] = "form_clientes_avulso"){ self::cadastrar();}
            }
            if(isset($_GET['saida']) == "saida-cliente-avulso"){self::calcular($_GET['v']);}
        }

        public function insertion()
        {
            $cliente = new ModelClienteAvulso;
            $cliente->setNome($_POST['nome']);
            $cliente->setRgCpf($_POST['rg_cpf']);
            $cliente->setTelCelular($_POST['telC']);
            $cliente->setPlaca($_POST['placa']);
            return $cliente;
        }

        public function cadastrar()
        {
            $cliAvulso = new ClientesAvulsos;
            $cliAvulso->create($this->insertion());
        }

        public function calcular($id)
        {
            $cliAvulso = new ClientesAvulsos;
            $cliAvulso->exit($id);
        }
        
        public function buscar()
        {
            $cliAvulso = new ClientesAvulsos;
            return $cliAvulso->list();
        }
    }

    new ClienteAvulso;