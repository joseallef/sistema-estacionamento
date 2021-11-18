<?php
    namespace AppC;
    require_once  '../../vendor/autoload.php';

    use AppM\ModelFinanceiro;
    use AppM\Financeiros;
    use Api\ConsultaFinanceiro;
    use AppM\ClienteFinanceiro;
    use AppC\TrataDados;
    use AppM\ModelCliente;
    use Api\GerarBoleto;
    use Api\Boleto;
    use Api\GerarPDF;
    use Api\Mensagem;
    class Financeiro
    {
        private $cnpj_cpf = "";
        private $tipo_pessoa = '';
        public function __construct()
        {
            if(isset($_POST['tabela'])){
                if($_POST['tabela'] == "form_financeiro"){ self::cadastrar();}
                if($_POST['tabela'] == "form_alter_financeiro"){ self::alterarFinanceiro();}           
            }
            if(isset($_GET['tabela']) && $_GET['tabela'] == "form_gera_boleto"){ self::gerarBoleto($_GET['v']);}
            if(isset($_GET['tabela']) && $_GET['tabela'] == "boleto_gerado"){ self::boletoGerado($_GET['v']);}
            if(isset($_GET['tabela']) && $_GET['tabela'] == "baixarBoleto"){ self::baixarBoleto($_GET['v']);}
        }

        public function insertion()
        {
            $modelFinanc = new ModelFinanceiro;
            $modelFinanc->setId(isset($_POST['id_veiculo'])? $_POST['id_veiculo']: $_POST['id_financeiro']);
            $modelFinanc->setValor($_POST['valor']);
            $modelFinanc->setVencimento($_POST['vencimento']);
            $modelFinanc->setAssunto(isset($_POST['assunto'])? $_POST['assunto']: "");
            $modelFinanc->setDataVencimento($_POST['vencimento']);
            return $modelFinanc;
        }

        public function cadastrar()
        {
            $financeiro = new Financeiros;
            $financeiro->createFinance($this->insertion());
            header("Location: cadastro-financeiro?valor=cadSuccess");
        }

        public function alterarFinanceiro()
        {
            $financeiros = new Financeiros;
            $financeiros->alterFinance($this->insertion());
            header("Location: alterar-financeiro?valor=cadSuccess");
        }
        
        public function resulmoFinanceiro($data_inicio, $data_fim)
        {
            return $this->consultaFinanceiro($filtarPor = 'TODOS', $data_inicio, $data_fim, $numPag = 0);
        }

        public function consultaFinanceiro($filtarPor = 'TODOS', $data_inicio, $data_fim, $numPag = 0)
        {
            $consutFinanc = new ConsultaFinanceiro();
            return $consutFinanc->consultaSituacaoFinanceira($filtarPor, $data_inicio, $data_fim, $numPag);
        }

        private function trataCpfCnpj($cpf_cnpj)
        {
            if(strlen($cpf_cnpj) == '14')
            {
                $cpfSemPonto = explode('.', $cpf_cnpj);                
                $cpf_cnpj = $cpfSemPonto[0].$cpfSemPonto[1].$cpfSemPonto[2];
                $cpfP = explode('-', $cpf_cnpj);
                $this->tipo_pessoa = ModelCliente::PESSOA_FISICA;
                return $cpfP[0].$cpfP[1];
            }else if(strlen($cpf_cnpj) == '18')
            {
                $cnpjSemBarra = explode('/', $cpf_cnpj);
                $cnpjSemBarra = $cnpjSemBarra[0].$cnpjSemBarra[1];
                $cnpjSemPonto = explode('.', $cnpjSemBarra);
                $cnpjSemPonto = $cnpjSemPonto[0].$cnpjSemPonto[1].$cnpjSemPonto[2];
                $cnpjSemTraco = explode('-', $cnpjSemPonto);
                $this->tipo_pessoa = ModelCliente::PESSOA_JURIDICA;
                return $cnpjSemTraco[0].$cnpjSemTraco[1];                 
            }
        }

        private function trataCep($cep)
        {
            $cepSemTraco = explode('-', $cep);
            return $cepSemTraco[0].$cepSemTraco[1];
        }

        private function trataNumeroFone($numero)
        {
            $num = explode('-', $numero);            
            $num1 = explode(' ', $num[0]);
            return $num1[1].$num[1];
        }

        private function trataDddFone($numero)
        {
            $num = explode(' ', $numero);
            $parent1 = explode('(', $num[0]);
            $parent2 = explode(')', $parent1[1]);            
            return $parent2[0];
        }

        private function boletoGerado($numeroBoleto)
        {
            $gerarPdf = new GerarPDF;
            $gerarPdf->geraPdf($name = '', $numeroBoleto);
        }

        public function gerarBoleto($id)
        {
            $clientFinanc = new ClienteFinanceiro;
            $trataDados = new TrataDados;
            $modelCliente = new ModelCliente;
            $crearBoleto = new GerarBoleto;
            $boleto = new Boleto;
            $mesangem = new Mensagem;

            $billetData = $clientFinanc->searchData($id);

            
            foreach($billetData as $data)
            {
                date_default_timezone_set('America/Sao_Paulo');
                $lastDateGeneratedBilet = $trataDados->vencimento($data['vencimento'], $data['dt_geracao']);
                $modelCliente->setNome($data['nome']);
                $modelCliente->setEmail($data['email']);
                $modelCliente->setCpf($this->trataCpfCnpj($data['cpf']));
                $modelCliente->setCep($this->trataCep($data['cep']));
                $modelCliente->setEstado($data['estado']);
                $modelCliente->setCidade($data['cidade']);
                $modelCliente->setBairro($data['bairro']);
                $modelCliente->setRua($data['rua']);
                $modelCliente->setNumero($data['numero']);
                $modelCliente->setComplemento($data['complemento']);
                $modelCliente->setTelMovel($this->trataNumeroFone($data['telmovel']));
                $modelCliente->setDdd($this->trataDddFone($data['telmovel']));
                $modelCliente->setTipoPessoa($this->tipo_pessoa);
                $mesangem->setLinha1("Informações relacionadas ao veiculo do responsével");
                $mesangem->setLinha2(strtoupper("Placa - ".$data['placa']));
                $mesangem->setLinha3(strtoupper("Modelo - ".$data['modelo']));
                $mesangem->setLinha4(strtoupper("Marca - ".$data['marca']));
                $mesangem->setLinha5(strtoupper("Cor - ".$data['cor']));
                $boleto->setCnpjCPFBeneficiario(getenv('CNPJ'));
                $boleto->setPagador($modelCliente);
                $boleto->setMensagem($mesangem);
                $boleto->setSeuNumero(substr($data['nome'], 0, 3));
                $boleto->setDataEmissao(date('Y-m-d'));
                $boleto->setValorNominal($data['valor']);
                $boleto->setDataVencimento($lastDateGeneratedBilet);
            }
            if($lastDateGeneratedBilet === $data['dt_geracao'])
            {
                $_SESSION['nao_autenticado'] = true;
                header("Location: gerar-boleto?boleto=Existente");
            }else{
                $crearBoleto->geraBoleto($boleto, $id);
            }
        }

        function baixarBoleto($numeroBoleto)
        {
            $baixarBoleto = new GerarBoleto;
            $baixarBoleto->baixarBoleto($numeroBoleto);
        }
    }
    new Financeiro;