<?php
    namespace AppC;
    
    require_once "../../vendor/autoload.php";

    use AppM\ModelVeiculo;
    use AppM\Veiculos;

class Veiculo
    {
        public function __construct()
        {
            if(isset($_POST['tabela'])){
                if($_POST['tabela'] == 'formVeiculo'){ self::cadastrar();}
                if($_POST['tabela'] == 'formAlterVeiculo'){ self::alterar();}
                if($_POST['tabela'] == "add_vaga"){ self::novaVaga($_POST['v_cont']);}
                if($_POST['tabela'] == "excluir_vaga"){ self::removeVaga($_POST['v_cont']);}
            }
            if(isset($_GET['tabela']))
            {
                if($_GET['tabela'] == 'excluir'){self::excluir($_GET['v']);}
            }
        }
        public function insertion()
        {
            $veiculo = new ModelVeiculo;
            $veiculo->setPlaca($_POST['placa']);
            $veiculo->setModelo($_POST['modelo']);
            $veiculo->setAno($_POST['ano']);
            $veiculo->setCor($_POST['cor']);
            $veiculo->setMarca($_POST['marca']);
            $veiculo->setEstado($_POST['estado']);
            $veiculo->setSeguro($_POST['seguro']);
            $veiculo->setId($_POST['id_cliente'] ? $_POST['id_cliente']: $_POST['id_veiculo']);
            return $veiculo;
        }

        public function cadastrar()
        {
            $veiculos = new Veiculos;
            $veiculos->create($this->insertion());
        }

        public function selecionaId($id)
        {
            $veiculos = new Veiculos;
            return $veiculos->selectAlter($id);
        }

        public function listarTodosVeiculos()
        {
            $veiculos = new Veiculos;
            return $veiculos->listAll();
        }

        public function listarPlacaVeiculo($placa)
        {
            $veiculos = new Veiculos;
            return $veiculos->searchBoard($placa);
        }

        public function alterar()
        {
            $veiculos = new Veiculos;
            $veiculos->update($this->insertion());
            header("Location: veiculos");
        }

        public function excluir($id)
        {
            $veiculos = new Veiculos;
            $veiculos->delete($id);            
            header("Location: veiculos");
        }

        public function exibeNomeResposavelCarro($id)
        {
            $veiculos = new Veiculos;
            return $veiculos->selectNameResCar($id);
        }

        public function novaVaga($quantidade)
        {
            $veiculos = new Veiculos;
            $veiculos->addVacancies($quantidade);
            header("Location: vagas");
        }

        public function removeVaga($quantidade)
        {
            $veiculos = new Veiculos;
            $veiculos->deleteVacacies(--$quantidade);
            header("Location: vagas");
        }
        public function exibeCarrosExCliente($id)
        {
            $veiculos = new Veiculos;
            return $veiculos->selectCarsFormerClients($id);
        }
    }
    new Veiculo;