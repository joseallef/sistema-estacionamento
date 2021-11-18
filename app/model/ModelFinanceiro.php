<?php
    namespace AppM;

    class ModelFinanceiro
    {
        private $valor = 0.0;
        private $vencimento;
        private $assunto;
        private $id;
        private $data_vencimento = array();

        public function getValor(){return $this->valor;}
        public function setValor($valor){$this->valor = $valor;}

        public function getVencimento(){return $this->vencimento;}
        public function setVencimento($vencimento){$this->vencimento = $vencimento;}

        public function getAssunto(){return $this->assunto;}
        public function setAssunto($assunto){$this->assunto = $assunto;}

        public function getDataVencimento(){return $this->data_vencimento;}
        public function setDataVencimento($data_vencimento){$this->data_vencimento = $data_vencimento;}

        public function getId(){return $this->id;}
        public function setId($id){$this->id = $id;}
    }