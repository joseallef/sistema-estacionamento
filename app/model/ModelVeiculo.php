<?php
    namespace AppM;

    class ModelVeiculo
    {
        private $placa;
        private $modelo;
        private $cor;
        private $marca;
        private $id;

        function getId(){return $this->id;}
        function setId($id){$this->id = $id;}

        function getPlaca(){return $this->placa;}
        function setPlaca($placa){$this->placa = $placa;}

        function getModelo(){return $this->modelo;}
        function setModelo($modelo){$this->modelo = $modelo;}

        function getCor(){return $this->cor;}
        function setCor($cor){$this->cor = $cor;}

        function getMarca(){return $this->marca;}
        function setMarca($marca){$this->marca = $marca;}

    }