<?php 
    namespace AppC;
    require_once "../../vendor/autoload.php";
    use AppM\Usuarios;
    class Usuario
    {
        public function __construct()
        {
            self::alterarUsuario();
        }
        public function alterarUsuario()
        {
            if(empty($_POST['usuario']) || empty($_POST['senha']) || empty($_POST['senha1']) || empty($_POST['senha2'])) {
                header('Location: alterar-usuario');
                exit();
            }

            $senha = md5($_POST['senha']);
            $novaSenha = md5($_POST['senha1']); // New password
            $confirmeNovaSenha = md5($_POST['senha2']); // Confirm the new password

            if($_POST['password'] == "autenticado")
            {                
                if($novaSenha == $confirmeNovaSenha)
                {
                    $usuarios = new Usuarios;
                    if(strlen($_POST['senha1'])  < 8)
                    {
                        setcookie('small_password',true, time()+1);
                        header('Location: alterar-usuario');
                        echo "<script> window.location.href='alterar-usuario';</script>";
                        exit();
                    }else
                    if($usuarios->alterUser($_POST['usuario'], $senha, $novaSenha)){
                        setcookie('cad_realizado',true, time()+1);
                        header("Location: index.php");
                        echo "<script> window.location.href='/';</script>";
                        exit();
                    }
                    else{
                        setcookie('nao_autenticado', true, time()+1);
                        header('Location: alterar-usuario');
                        echo "<script> window.location.href='alterar-usuario';</script>";
                        exit();
                    }
                }else{
                    setcookie('nao_autentico', true, time()+1);
                    header('Location: alterar-usuario');
                    echo "<script> window.location.href='alterar-usuario';</script>";
                    exit();
                }

            }else{
                setcookie('nao_autenticado', true, time()+1);
                header('Location: alterar-usuario');
                echo "<script> window.location.href='alterar-usuario';</script>";
                exit();
            }
        }
    }
    new Usuario;