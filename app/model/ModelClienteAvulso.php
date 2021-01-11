<?php
    namespace AppM;

    class ModelClienteAvulso
    {
        private $nome;
        private $rg_cpf;
        private $tel_celular;
        private $placa;

        public function getNome(){return $this->nome; }
        public function setNome($nome){$this->nome = $nome;}
        
        public function getRgCpf(){return $this->rg_cpf; }
        public function setRgCpf($rg_cpf){$this->rg_cpf = $rg_cpf;}
        
        public function getTelCelular(){return $this->tel_celular; }
        public function setTelCelular($tel_celular){$this->tel_celular = $tel_celular;}

        public function getPlaca(){return $this->placa; }
        public function setPlaca($placa){$this->placa = $placa;}
    }