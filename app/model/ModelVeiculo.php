<?php
    namespace AppM;

    class ModelVeiculo
    {
        private $placa;
        private $modelo;
        private $cor;
        private $ano;
        private $marca;
        private $estado;
        private $seguro;
        private $id;

        function getId(){return $this->id;}
        function setId($id){$this->id = $id;}

        function getPlaca(){return $this->placa;}
        function setPlaca($placa){$this->placa = $placa;}

        function getModelo(){return $this->modelo;}
        function setModelo($modelo){$this->modelo = $modelo;}

        function getCor(){return $this->cor;}
        function setCor($cor){$this->cor = $cor;}

        function getAno(){return $this->ano;}
        function setAno($ano){$this->ano = $ano;}

        function getMarca(){return $this->marca;}
        function setMarca($marca){$this->marca = $marca;}

        function getEstado(){return $this->estado;}
        function setEstado($estado){$this->estado = $estado;}

        function getSeguro(){return $this->seguro;}
        function setSeguro($seguro){$this->seguro = $seguro;}

    }