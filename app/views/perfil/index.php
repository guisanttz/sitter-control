<?php
// Gera iniciais para o avatar
$iniciais = 'CU';
if (!empty($perfilDados['nome'])) {
    $partes = preg_split('/\s+/', trim($perfilDados['nome']));
    $iniciais = mb_strtoupper(mb_substr($partes[0], 0, 1));
    if (count($partes) > 1) {
        $iniciais .= mb_strtoupper(mb_substr(end($partes), 0, 1));
    }
}
?>

<div class="profile-card">
    <div class="profile-top">
        <div class="avatar avatar-lg"><?= htmlspecialchars($iniciais) ?></div>
        <div>
            <div class="name"><?= htmlspecialchars($perfilDados['nome'] ?? 'Usuário') ?></div>
            <div class="sub">Cuidadora principal</div>
        </div>
        <button type="button" class="btn btn-outline" style="margin-left:auto;" onclick="showToast('Upload de foto estará disponível em breve.')">
            Alterar foto
        </button>
    </div>

    <!-- Formulário de dados pessoais -->
    <form method="POST" action="index.php?pagina=perfil&acao=atualizar_perfil">
        <div class="grid-2">
            <div class="field">
                <label for="perfil-nome">Nome</label>
                <input type="text" id="perfil-nome" name="nome"
                       value="<?= htmlspecialchars($perfilDados['nome'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="perfil-telefone">Telefone</label>
                <input type="tel" id="perfil-telefone" name="telefone"
                       value="<?= htmlspecialchars($perfilDados['telefone'] ?? '') ?>"
                       placeholder="(00) 00000-0000">
            </div>
        </div>
        <div class="field">
            <label for="perfil-email">E-mail</label>
            <input type="email" id="perfil-email" name="email"
                   value="<?= htmlspecialchars($perfilDados['email'] ?? '') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>

    <div class="divider"></div>

    <!-- Formulário de alteração de senha -->
    <h3 style="font-size:16px;margin-bottom:16px;">Alterar senha</h3>
    <form method="POST" action="index.php?pagina=perfil&acao=alterar_senha" id="form-senha">
        <div class="field">
            <label for="senha-atual">Senha atual</label>
            <input type="password" id="senha-atual" name="senha_atual" placeholder="••••••••" required>
        </div>
        <div class="grid-2">
            <div class="field">
                <label for="nova-senha">Nova senha</label>
                <input type="password" id="nova-senha" name="nova_senha"
                       placeholder="••••••••" minlength="6" required>
            </div>
            <div class="field">
                <label for="confirmar-senha">Confirmar nova senha</label>
                <input type="password" id="confirmar-senha" name="confirmar_senha"
                       placeholder="••••••••" minlength="6" required>
            </div>
        </div>
        <button type="submit" class="btn btn-ghost">Atualizar senha</button>
    </form>
</div>

<script>
// Validação client-side da confirmação de senha
document.getElementById('form-senha').addEventListener('submit', function(e) {
    var nova = document.getElementById('nova-senha').value;
    var confirmar = document.getElementById('confirmar-senha').value;
    if (nova !== confirmar) {
        e.preventDefault();
        showToast('A nova senha e a confirmação não coincidem.', 'erro');
    }
});
</script>
