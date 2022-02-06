<?php
 include ("head.php");
?>
<body>
    <main class="center container-xs">
        <div class="flex flex--coluna px3">
            <section class=" cartao--container cartao-xs">
                <div class="border-bottom">
                    <img src="assets/img/icon/Logo-palp-it.svg" alt="Logo Palp-it"/>
                    <h2 class="container--titulo mb-2">Recuperar senha</h2> 
                </div>
                <p class="text-justify my-3">  Um email de confirmação foi enviado para o endereço <a class="link" > <?php echo $_SESSION['email'] ?> </a>. </p>
                <button class="botao--container botao--primario width-full"> <a href="inicio.php" >Voltar para página inicial</a></button>
            </section>
        </div>
    </main>
    </body>
</html>
