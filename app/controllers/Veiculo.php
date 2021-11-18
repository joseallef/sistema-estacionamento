<?php

namespace AppC;

require_once "../../vendor/autoload.php";

use AppM\ModelVeiculo;
use AppM\Veiculos;
use AppC\Criptor;

class Veiculo
{
    public function __construct()
    {
        if (isset($_POST['tabela'])) {
            if ($_POST['tabela'] == 'formVeiculo') {
                self::cadastrar();
            }
            if ($_POST['tabela'] == 'formAlterVeiculo') {
                self::alterar();
            }
            if ($_POST['tabela'] == "add_vaga") {
                self::novaVaga($_POST['v_cont']);
            }
            if ($_POST['tabela'] == "excluir_vaga") {
                self::removeVaga($_POST['v_cont']);
            }
        }
        if (isset($_GET['tabela'])) {
            if ($_GET['tabela'] == 'excluir') {
                self::excluir($_GET['v']);
            }
            if ($_GET['tabela'] == 'excluir-permanentimente') {
                self::excluirPermanentimente($_GET['v']);
            }
        }
    }


    public function marcaDoCarro($numeroMarca)
    {

        if ($numeroMarca == '6') {
            $numeroMarca = 'Audi';
        }
        if ($numeroMarca == '7') {
            $numeroMarca = 'BMW';
        }
        if ($numeroMarca == '13') {
            $numeroMarca = 'Citroén';
        }
        if ($numeroMarca == '21') {
            $numeroMarca = 'Fiat';
        }
        if ($numeroMarca == '22') {
            $numeroMarca = 'Ford';
        }
        if ($numeroMarca == '23') {
            $numeroMarca = 'Chevrolet';
        }
        if ($numeroMarca == '25') {
            $numeroMarca = 'Honda';
        }
        if ($numeroMarca == '26') {
            $numeroMarca = 'Hyundai';
        }
        if ($numeroMarca == '29') {
            $numeroMarca = 'Jeep';
        }
        if ($numeroMarca == '31') {
            $numeroMarca = 'Kia';
        }
        if ($numeroMarca == '33') {
            $numeroMarca = 'Land Rover';
        }
        if ($numeroMarca == '39') {
            $numeroMarca = 'Mercedes-Benz';
        }
        if ($numeroMarca == '43') {
            $numeroMarca = 'Nissan';
        }
        if ($numeroMarca == '41') {
            $numeroMarca = 'Mitsubishi';
        }
        if ($numeroMarca == '44') {
            $numeroMarca = 'Peugeot';
        }
        if ($numeroMarca == '47') {
            $numeroMarca = 'Porsche';
        }
        if ($numeroMarca == '48') {
            $numeroMarca = 'Renault';
        }
        if ($numeroMarca == '55') {
            $numeroMarca = 'Suzuki';
        }
        if ($numeroMarca == '56') {
            $numeroMarca = 'Toyota';
        }
        if ($numeroMarca == '58') {
            $numeroMarca = 'Volvo';
        }
        if ($numeroMarca == '59') {
            $numeroMarca = 'VolksWagen';
        }
        if ($numeroMarca == '161') {
            $numeroMarca = 'Chery';
        }
        if ($numeroMarca == '177') {
            $numeroMarca = 'Jac Motors';
        }
        if ($numeroMarca == 'outros') {
            $numeroMarca = $numeroMarca;
        }
        return $numeroMarca;
    }

    public function insertion()
    {
        $veiculo = new ModelVeiculo;
        $veiculo->setPlaca($_POST['placa']);
        $veiculo->setModelo($_POST['modelo']);
        $veiculo->setCor($_POST['cor']);
        $veiculo->setMarca($this->marcaDoCarro($_POST['marca']));
        $veiculo->setId($_POST['id_cliente'] ? $_POST['id_cliente'] : $_POST['id_veiculo']);
        return $veiculo;
    }

    public function cadastrar()
    {
        $criptor = new Criptor();
        $veiculos = new Veiculos;
        $id_veiculo = $veiculos->create($this->insertion());
        header("Location: cadastro-financeiro?v=" . $criptor->base64($id_veiculo, 1));
    }

    public function selecionaId($id)
    {
        $veiculos = new Veiculos;
        return $veiculos->selectAlter($id);
    }

    public function listarTodosVeiculosAtivos()
    {
        $veiculos = new Veiculos;
        $veiculo = $veiculos->listAllVehicleActives();
        if ($veiculo !== null) {
            return $veiculo;
        } else {
            $_SESSION['nao_autenticado'] = true;
            return false;
        }
    }
    public function listarTodosVeiculos()
    {
        $veiculos = new Veiculos;
        $veiculo = $veiculos->listAllVehicle();
        if ($veiculo !== null) {
            return $veiculo;
        } else {
            $_SESSION['nao_autenticado'] = true;
            return false;
        }
    }

    public function listarPlacaVeiculo($placa)
    {
        $veiculos = new Veiculos;
        $veiculo = $veiculos->searchBoard($placa);
        if ($veiculo !== null) {
            return $veiculo;
        } else {
            $_SESSION['nao_autenticado'] = true;
            return false;
        }
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
    public function excluirPermanentimente($id)
    {
        $veiculos = new Veiculos;
        $status = $veiculos->permanentlyDelete($id);
        header("Location: mais-detahes-veiculos?delete=" . $status);
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
