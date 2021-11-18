<?php
require_once "../../lib/dep-style.php";
?>
<nav class="navbar navbar-expand-lg  bg-dark fixed-top pb-0 p-4">
    <button type="button" class="navbar-toggle bg-dark" id="menu" data-toggle="collapse" data-target=".menu">
        <div class="mian navbar navbar-expand navbar-dark">
            <div class="navbar-toggler-icon"></div>
            <div class="iconn"></div>
            <div class="text-secondary p-1">
                Menu
            </div>
        </div>
    </button>
    <div class="navbar text text-right bg-info relogio ml-3 head-mobile">
        <span id="relogio"></span>
    </div>
    <div class="text text-center head-mobile" style="color:#fff; margin: 0 auto; font-style: noraml;font-size: 1.6em;">
        Sejá bem vindo: <span class="usuario"></span>
    </div>
</nav>
<div class="wrapper">
    <aside class="main_sidebar menu">
        <ul class="mt-3">
            <!-- <li><i class="fa fa-home"></i><a href="vagas">Vagas</a></li> -->
            <li><i class="fa fa-users"></i><a href="opcoes-clientes">Clientes</a></li>
            <li><i class="fa fa-car"></i><a href="veiculos">Veículos</a></li>
            <li><i class="fa fa-dollar"></i><a href="financeiro">Financeiro</a></li>
            <li><i class="fa fa-plus-square"></i><a href="conteudo-avancado">Avançado</a></li>
            <li><i class="fas fa-retweet" aria-hidden="true"></i><a href="alterar-usuario">Alterar senha</a></li>
            <li><i class="far fa-times-circle"></i><a href="logout">Sair</a></li>
        </ul>
    </aside>
</div>
<div class="shadow-right">
</div>