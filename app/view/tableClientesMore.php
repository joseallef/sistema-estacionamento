<?php
    session_start();
    require_once "../../vendor/autoload.php";
    use AppC\Token;
    $token = new Token();   
    if($token->checkAuth()){}else{header("Location: index.php");}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastro de Clientes</title>
        <link rel="shurtcut icon" type="image/png" href="public/img/car1.png"/> 
    </head>
    <body>
    <?php
        require_once "menu.php";
        require_once "../controllers/Cliente.php";
        use AppC\Cliente;
        use AppC\Criptor;
        $criptor = new Criptor();
        $cliente = new Cliente();
        
    ?>
    <div class="container-field mt-5">
        <table class="table mt-5">
            <thead class="mt-5">
                <tr class="mt-5">
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>E-mail</th> 
                    <th>Cpf/CNPJ</th>                                            
                    <th>Tel Celular</th>   
                    <th>Cep</th>
                    <th>UF</th>
                    <th>Cidade</th>
                    <th>Bairro</th>
                    <th>Rua</th>
                    <th>Nº</th>          
                </tr>
            </thead>
            <?php
                foreach($cliente->listarTodosDadosCliente($criptor->base64($_GET['v'], 2)) as $reg)
                {				
                    $id = $reg['id'];
            ?>
            <tbody>
                <tr>
                    <td><img src="public/image/<?php echo $reg['foto']; ?>" class="rounded"/></td>
                    <td><?php echo $reg['nome']; ?></td>
                    <td><?php echo $reg['email']; ?></td>
                    <td><?php echo $reg['cpf']; ?></td>
                    <td><?php echo $reg['telmovel']; ?></td> 
                    <td><?php echo $reg['cep']; ?></td>
                    <td><?php echo $reg['estado']; ?></td>
                    <td><?php echo $reg['cidade']; ?></td>
                    <td><?php echo $reg['bairro']; ?></td>
                    <td><?php echo $reg['rua']; ?></td>
                    <td><?php echo $reg['numero']; echo "-". $reg['complemento']; ?></td>
                </tr>
            </tbody>
            <?php
                }
            ?>
            
        </table>
    </div><br>
    <div class="container">
        <table class="table">
            <thead>
                <?php
                    if($cliente->geraContrato($id))
                    {
                        foreach($cliente->geraContrato($id) as $reg){
                            $nome = $reg['nome'];
                        }
                    }
                ?>
                <tr>
                    <th>Alterar</th>
                    <th>Excluir</th>
                    <th>Veículo</th>
                <?php 
                    if(!empty($nome))
                    {
                ?>
                    <th>Gerar Contrato</th> 
                <?php
                    }
                ?>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="alterar-cliente?v=<?php echo $criptor->base64($id, 1); ?>" class="btn btn-warning"><i class="fa fa-user-edit"></i></a></td>
                    <td><button data-toggle="modal" class="btn btn-danger" data-target="#excluir-cliente"><img src="public/img/icondelete.png"></button></td>
                    <td><a href="formulario-veiculo?v=<?php echo $criptor->base64($id, 1); ?>" class="btn btn-secondary"><img src="public/img/iconadd.png"></a></td>
                    <?php
                        if(!empty($nome)){
                    ?>
                        <td><a href="contrato?v=<?php echo $criptor->base64($id, 1); ?>" target="_blank" class="btn btn-primary"><i class="fab fa-creative-commons-share"></i></td>
                    <?php
                        }
                    ?>
                </tr>
            </body>
        </table>
    </div>
        <div class="modal fade" id="excluir-cliente" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="cadSuccess" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tem certeza que dezeja excluir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="incluir-alter" method="POST">
                            <div class="form-group">
                                <div class="text text-center">
                                    <label for="message-text" class="col-form-label">Motivo pelo qual o cliente estar saindo:</label>
                                </div>
                                <textarea class="form-control" id="message-text" name="assunto" required cols="30" rows="4"  placeholder="Assunto..."></textarea>
                            </div>
                            <input type="hidden" name="tabela" value="excluir">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" name="v" value="<?php echo $id; ?>"><img src="public/img/icondelete.png" alt="Apagar"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            require_once "../../lib/dep-script.php";
        ?>
    </body>
</html>