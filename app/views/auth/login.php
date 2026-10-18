<div id="page-login">
    <div class="login-hero">
        <svg class="blob" width="420" height="420" viewBox="0 0 420 420" style="top:-90px;right:-110px;">
            <circle cx="210" cy="210" r="210" fill="#F5FBEF" />
        </svg>
        <div class="brand">
            <div class="logo-badge"><svg>
                    <use href="#i-sprout" />
                </svg></div>
            <span>SitterControl</span>
        </div>
        <div class="message">
            <h1>Cuidado organizado, dia a dia mais leve.</h1>
            <p>Cadastros, tarefas e contas das crianças que você acompanha, tudo em um só lugar.</p>
        </div>
        <div class="foot">© 2026 SitterControl</div>
    </div>
    <div class="login-form-side">
        <div class="login-form-wrap">
            <h2>Bem-vinda de volta</h2>
            <p class="sub">Entre com sua conta para continuar.</p>
            <form action="index.php?acao=fazer_login" method="POST">
                <div class="field">
                    <label for="login-email">E-mail</label>
                    <input id="login-email" name="email" type="email" placeholder="" required>
                </div>
                <div class="field">
                    <label for="login-senha">Senha</label>
                    <input id="login-senha" name="senha" type="password" placeholder="••••••••" required>
                </div>
                <div class="row-between">
                    <label class="checkbox-line"><input type="checkbox" checked> Manter conectada</label>
                    <a href="#" class="link">Esqueceu a senha?</a>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </div>
</div>