<?php
    namespace AppC;

    use AppM\ExClientes;
    class ExCliente
    {
        function listarTodosExClientes()
        {
            $excli = new ExClientes;
            return $excli->listAllExClient();
        }

        function listarExclientePorNome($nome)
        {
            $excli = new ExClientes;
            return $excli->listExClientByName($nome);
        }

        function listarExclientePorCpf($cpf)
        {
            $excli = new ExClientes;
            return $excli->listExClientByCpf($cpf);
        }

        
        function listarExClientePorId($id)
        {
            $excli = new ExClientes;
            return $excli->listExClientById($id);
        }

        function buscarExClientePorplaca($placa)
        {
            $excli = new ExClientes;
            return $excli->searchExClientByBoard($placa);
        }

        function listarExclientePorData($data_inicio, $data_fim)
        {
            $excli = new ExClientes;
            return $excli->searchExClientByDate($data_inicio, $data_fim);
        }

        function listaInformacoesCliente($id)
        {
            $excli = new ExClientes;
            return $excli->listInformationClient($id);
        }
    }