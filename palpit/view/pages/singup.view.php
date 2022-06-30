<main class="flex flex-coluna">
    <div class="px-3 container-xs" style="margin: auto; width: 100%">
        <section class=" cartao__container cartao-xs">
            <div class="border-bottom">
                <a href="inicio.php">
                    <img src="assets/img/icon/Logo.svg" alt="Logo Palp-it" />
                </a>
                <h2 class="container--titulo mb-2">Cadastre-se no Palp-it</h2>
            </div>
            <div>
                <form method="POST">
                    <div class="input-container">
                        <input 
                            name="nome" 
                            id="nome" 
                            class="input input-full" 
                            type="text" 
                            placeholder="Nome Completo" 
                            required
                        />
                    </div>
                    <div class="input-container">
                        <input 
                            name="email" 
                            id="email" 
                            class="input input-full" 
                            type="email" 
                            placeholder="Email" 
                            required
                        />
                    </div>
                    <div class="input-container">
                        <input 
                            name="senha" 
                            id="senha" 
                            class="input input-full" 
                            type="password" 
                            placeholder="Senha" 
                            title="A senha deve conter entre 6 a 100 caracteres, deve conter pelo menos uma letra maiúscula, um número e não deve conter símbolos." 
                            required
                        />
                    </div>
                    <div class="input-container">
                        <input 
                            name="senha" 
                            id="senha" 
                            class="input input-full" 
                            type="password" 
                            placeholder="Confirmação de senha" 
                            title="A senha deve conter entre 6 a 100 caracteres, deve conter pelo menos uma letra maiúscula, um número e não deve conter símbolos." 
                            required
                        />
                    </div>
                    <div class="input-container">
                        <select class="option input input-full" name="area">
                            <option disabled selected>Selecione uma Área de interesse</option>
                            <?php foreach ($areas as $area): ?>
                                <option value="<?= $area->id_area ?>"><?= $area->nome_area ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="checkbox--label ">
                        <input type="checkbox" name="receber"/>
                        Aceito receber notificação por email quando um novo gráfico da minha área de interesse for postado.
                    </label>
                    <button type="submit" class="botao--container botao--primario width-full">Cadastrar</button>
                </form>
            </div>
        </section>
        <section class="cartao__container cartao-xs">
            <p>Já é membro?</p>
            <a href="login" class="link link-color link-externo">
                Entre já
            </a>
        </section>
    </div>
</main>