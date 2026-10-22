<!-- ================= MODAL DE CONFIRMAÇÃO DE EXCLUSÃO ================= -->
<div class="modal-overlay hidden" id="modal-confirm-delete">
    <div class="modal" style="max-width:420px;">
        <div class="modal-delete-box">
            <div class="del-icon-wrap">
                <svg><use href="#i-alert" /></svg>
            </div>
            <h3 id="modal-delete-title">Confirmar exclusão</h3>
            <p id="modal-delete-msg">Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.</p>
            <div class="modal-actions" style="margin-top:24px;">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-confirm-delete')">Cancelar</button>
                <a href="#" id="modal-delete-btn" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    </div>
</div>

<!-- ================= TOAST DE NOTIFICAÇÃO ================= -->
<div class="toast" id="toast">
    <svg><use href="#i-check" /></svg>
    <span id="toast-msg">Operação realizada com sucesso.</span>
</div>

<?php
// Centralizador global de mensagens toast via query string
$mensagensGlobais = [
    // Crianças
    'crianca_cadastrada'       => ['tipo' => 'sucesso', 'texto' => 'Criança cadastrada com sucesso!'],
    'crianca_atualizada'       => ['tipo' => 'sucesso', 'texto' => 'Dados da criança atualizados com sucesso!'],
    'crianca_excluida'         => ['tipo' => 'sucesso', 'texto' => 'Criança removida com sucesso!'],
    // Responsáveis
    'responsavel_cadastrado'   => ['tipo' => 'sucesso', 'texto' => 'Responsável cadastrado com sucesso!'],
    'responsavel_atualizado'   => ['tipo' => 'sucesso', 'texto' => 'Responsável atualizado com sucesso!'],
    'responsavel_excluido'     => ['tipo' => 'sucesso', 'texto' => 'Responsável removido com sucesso!'],
    'responsavel_com_criancas' => ['tipo' => 'erro',    'texto' => 'Não é possível excluir: existem crianças vinculadas a este responsável.'],
    // Tarefas
    'tarefa_cadastrada'        => ['tipo' => 'sucesso', 'texto' => 'Tarefa cadastrada com sucesso!'],
    'tarefa_atualizada'        => ['tipo' => 'sucesso', 'texto' => 'Tarefa atualizada com sucesso!'],
    'tarefa_excluida'          => ['tipo' => 'sucesso', 'texto' => 'Tarefa removida com sucesso!'],
    'tarefa_status_alterado'   => ['tipo' => 'sucesso', 'texto' => 'Status da tarefa atualizado!'],
    // Pagamentos
    'pagamento_cadastrado'     => ['tipo' => 'sucesso', 'texto' => 'Pagamento cadastrado com sucesso!'],
    'pagamento_atualizado'     => ['tipo' => 'sucesso', 'texto' => 'Pagamento atualizado com sucesso!'],
    'pagamento_excluido'       => ['tipo' => 'sucesso', 'texto' => 'Pagamento removido com sucesso!'],
    // Perfil
    'perfil_atualizado'        => ['tipo' => 'sucesso', 'texto' => 'Perfil atualizado com sucesso!'],
    'erro_perfil'              => ['tipo' => 'erro',    'texto' => 'Erro ao atualizar o perfil. Tente novamente.'],
    'email_em_uso'             => ['tipo' => 'erro',    'texto' => 'Este e-mail já está em uso por outro cadastro.'],
    'email_invalido'           => ['tipo' => 'erro',    'texto' => 'Por favor, informe um endereço de e-mail válido.'],
    'campos_obrigatorios'      => ['tipo' => 'erro',    'texto' => 'Nome e e-mail são obrigatórios.'],
    'senha_incorreta'          => ['tipo' => 'erro',    'texto' => 'A senha atual informada está incorreta.'],
    'senhas_diferentes'        => ['tipo' => 'erro',    'texto' => 'A nova senha e a confirmação não coincidem.'],
    'senha_curta'              => ['tipo' => 'erro',    'texto' => 'A nova senha deve ter pelo menos 6 caracteres.'],
    'campos_vazios'            => ['tipo' => 'erro',    'texto' => 'Preencha todos os campos de senha.'],
    // Genéricos
    'sucesso'                  => ['tipo' => 'sucesso', 'texto' => 'Operação realizada com sucesso!'],
    'erro'                     => ['tipo' => 'erro',    'texto' => 'Ocorreu um erro ao processar a ação. Tente novamente.']
];

$msgKey = $_GET['msg'] ?? '';
$notificacaoToast = $mensagensGlobais[$msgKey] ?? null;
?>

<script src="assets/js/main.js"></script>

<?php if ($notificacaoToast): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('<?= addslashes($notificacaoToast['texto']) ?>', '<?= $notificacaoToast['tipo'] ?>');
    });
</script>
<?php endif; ?>

</body>
</html>
