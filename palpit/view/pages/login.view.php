<main class="flex flex-coluna">
    <div class="px-3 container-xs" style="margin: auto; width: 100%">
        <form method="post" class="cartao__container cartao-xs">
            <div class="border-bottom">
                <a href="/">
                    <img src="assets/img/icon/Logo.svg" alt="Logo Palp-it" />
                </a>
                <h2 class="container--titulo mb-2 mt-2">Entre no Palp-it</h2>
            </div>
            <div class="mensagem-erro">
                <?php if (isset($errors['login']) && !empty($errors['login'])): ?>
                    <span><?= $errors['login'] ?></span>
                <?php endif; ?>
            </div>
            <div class="input-container">
                <input 
                    name="email"
                    class="input width-full" 
                    type="email" 
                    placeholder="Email" 
                    required
                />
            </div>
            <div class="mensagem-erro">
                <?php if (isset($errors['email']) && !empty($errors['email'])): ?>
                    <span><?= $errors['email'] ?></span>
                <?php endif; ?>
            </div>
            <div class="input-container" style="margin-top: 1em;">
                <input 
                    name="senha"
                    class="input width-full" 
                    type="password" 
                    placeholder="Senha" 
                    title="A senha deve conter entre 6 a 12 caracteres, deve conter pelo menos uma letra maiúscula, um número e não deve conter símbolos." 
                    required
                />
            </div>
            <div class="mensagem-erro">
                <?php if (isset($errors['senha']) && !empty($errors['senha'])): ?>
                    <span><?= $errors['senha'] ?></span>
                <?php endif; ?>
            </div>
            <a 
                href="reset_senha_email.php" 
                class="flex--right link-container link-color" 
                style="margin-top: 1em;"
            >
                Esqueceu sua senha?
            </a>
            <button 
                type="submit"
                class="botao--container botao--primario width-full"
            >
                Entrar
            </button>
        </form>
        <section class="cartao__container cartao-xs">
            <p>Ainda não é membro?</p> 
            <a href="cadastro" class="link-container link-color link-externo">
                Cadastre-se já
            </a>
        </section>
    </div>
</main>