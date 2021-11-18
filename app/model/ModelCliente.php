<?php
    namespace AppM;

    class ModelCliente implements \JsonSerializable
    {
        private $id;
        private $nome;
        private $email;
        private $cnpjCpf;
        private $cep;
        private $uf;
        private $cidade;
        private $bairro;
        private $endereco;
        private $numero;
        private $complemento;
        private $telefone;
        private $ddd;
        private $file = [];
        private $data_entrada;
        private $situacao;
        private $tipoPessoa = null;

        const PESSOA_FISICA = "FISICA";
        const PESSOA_JURIDICA = "JURIDICA";

        public function getId(){return $this->id;}
        public function setId($id){$this->id = $id; }

        public function getNome()
        {
            return $this->nome;
        }
        public function setNome($nome)
        {
            $this->nome = $nome;
        }

        public function getTipoPessoa(){return $this->tipoPessoa;}
        public function setTipoPessoa($tipoPessoa){$this->tipoPessoa = $tipoPessoa; }

        public function getEmail(){return $this->email;}
        public function setEmail($email){$this->email = $email; }

        public function getCpf(){return $this->cnpjCpf;}
        public function setCpf($cnpjCpf){$this->cnpjCpf = $cnpjCpf;}

        public function getCep(){return $this->cep; }
        public function setCep($cep){$this->cep = $cep; }

        public function getEstado(){return $this->uf; }
        public function setEstado($uf){$this->uf = $uf;}

        public function getCidade(){return $this->cidade; }
        public function setCidade($cidade){$this->cidade = $cidade;}

        public function getBairro(){return $this->bairro; }
        public function setBairro($bairro){$this->bairro = $bairro;}

        public function getRua(){return $this->endereco; }
        public function setRua($endereco){$this->endereco = $endereco;}

        public function getNumero(){return $this->numero; }
        public function setNumero($numero){$this->numero = $numero;}

        public function getComplemento(){return $this->complemento; }
        public function setComplemento($complemento){$this->complemento = $complemento;}

        
        public function getTelMovel(){return $this->telefone; }
        public function setTelMovel($telefone){$this->telefone = $telefone;}

        public function getDdd(){return $this->ddd; }
        public function setDdd($ddd){$this->ddd = $ddd;}

        public function getFile(){return $this->file; }
        public function setFile($file = []){$this->file = $file;}

        public function getDataEntrada(){return $this->data_entrada; }
        public function setDataEntrada($data_entrada){$this->data_entrada = $data_entrada;}

        public function getSituacao(){return $this->situacao; }
        public function setSituacao($situacao){$this->situacao = $situacao;}

        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
        
    }