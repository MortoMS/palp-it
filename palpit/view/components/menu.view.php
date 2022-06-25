<?php

use App\Providers\AuthProvider as Auth;

?>
<?php if (!Auth::check()): ?>
    <header class="cabecalho">
        <div class="cabecalho__content">
            <div class="cabecalho__left-side flex flex-items-center">
                <a href="/" class="flex">
                    <img src="assets/img/icon/Logo.svg" alt="Logo Palp-it" />
                </a>
                <div class="cabecalho--pesquisa ">
                    <input 
                        type="search" 
                        placeholder="Pesquisar"
                        class="search-icon input-pesquisa botao--container border"
                    >
                </div>
            </div>
            <div class="cabecalho__right-side">
                <nav>
                    <ul class="flex">
                        <li>
                            <a href="login" class="botao--container">Entrar</a>
                        </li>
                        <li>
                            <a href="cadastro.php" class="botao--container border">Criar conta</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
<?php else: ?>
    <header class="cabecalho">
        <div class="cabecalho__content">
            <div class="cabecalho__left-side flex flex-items-center">
                <a href="inicio.php" class="flex">
                    <img src="assets/img/icon/Logo.svg" alt="Logo Palp-it" />
                </a>
                <div class="cabecalho--pesquisa">
                    <input type="search" placeholder="Pesquisar" class="input-pesquisa">
                </div>
                <nav class="cabecalho--navegacao items-xl">
                    <ul class="flex flex-items-center">
                        <li id="btn-inicio" class="botao--container active">
                            <a href="inicio.php" class="user__link">
                                <span class="material-icons ">home</span>
                                Início
                            </a>
                        </li>
                        <li id="btn-perfil" class="botao--container">
                            <a href="perfil.php" class="user__link">
                                <span class="material-icons">person</span>
                                Perfil
                            </a>
                        </li>
                        <li id="btn-contribuicoes" class="botao--container">
                            <a href="contribuicoes.php" class="user__link ">
                                <span class="material-icons">file_upload</span>
                                Contribuições
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="items-xl cabecalho__right-side flex">
                <a href="envio.php">
                    <div class=" botao-cabecalho botao--container border">
                        <span class="material-icons-outlined">add</span>
                        Novo envio
                    </div>
                </a>
                <div class="avt-container avt-cab ml-3">
                    <div class="avt-content">
                        <img class="avt" src="<?= Auth::user()->foto_p ?>" alt="Foto de perfil">
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn material-icons-outlined">
                        expand_more
                    </button>
                    <div id="myDropdown" class="caixa user__menu">
                        <ul>
                            <li class="caixa-item">
                                <a href="perfil.php?editar=1">Editar Perfil</a>
                            </li>
                            <li class="caixa-item">
                                <a href="/logout">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="js-menu" class="botao--container menu">
                <span class="menu-icon material-icons-outlined">menu</span>
            </div>
        </div>
    </header>
    <script src="public/assets/js/cabecalho.js"></script>  
<?php endif; ?>