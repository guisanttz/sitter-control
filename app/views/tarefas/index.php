<?php
$tarefasPendentes = array_filter($listaTarefas, fn($t) => empty($t['concluida']));
$tarefasConcluidas = array_filter($listaTarefas, fn($t) => !empty($t['concluida']));
?>

<div class="list-head">
    <div class="counter-row">
        <div class="counter-pill">Pendentes: <span id="count-pendentes"><?= count($tarefasPendentes) ?></span></div>
        <div class="counter-pill">Concluídas: <span id="count-concluidas"><?= count($tarefasConcluidas) ?></span></div>
    </div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="abrirModalTarefa()">
            <svg><use href="#i-plus" /></svg>Nova tarefa
        </button>
    </div>
</div>

<?php if (empty($listaTarefas)): ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg><use href="#i-check-square" /></svg>
        </div>
        <h4>Nenhuma tarefa cadastrada</h4>
        <p>Crie lembretes para medicações, horários de soneca, alimentação ou atividades.</p>
        <button class="btn btn-primary" style="width:auto;margin-top:8px;" onclick="abrirModalTarefa()">
            <svg><use href="#i-plus" /></svg>Criar primeira tarefa
        </button>
    </div>
<?php else: ?>
    <!-- SEÇÃO PENDENTES -->
    <p class="task-section-title">Pendentes</p>
    <div class="task-list-panel" id="tarefas-pendentes-panel" style="margin-bottom:28px;">
        <?php if (empty($tarefasPendentes)): ?>
            <div style="padding:16px 0;color:var(--ink-faint);font-size:13.5px;text-align:center;">
                Todas as tarefas foram concluídas! 🎉
            </div>
        <?php else: ?>
            <?php foreach ($tarefasPendentes as $t): ?>
                <?php
                $jsonDados = htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8');
                $horarioFormatado = '';
                if (!empty($t['horario'])) {
                    $partesH = explode(':', $t['horario']);
                    $horarioFormatado = $partesH[1] == '00' ? $partesH[0] . 'h' : $partesH[0] . 'h' . $partesH[1];
                }
                ?>
                <div class="task-item" data-id="<?= $t['id'] ?>">
                    <div class="task-check" onclick="toggleTask(this, <?= $t['id'] ?>)" title="Marcar como concluída">
                        <svg><use href="#i-check" /></svg>
                    </div>
                    <div class="task-title" title="<?= htmlspecialchars($t['observacoes'] ?? '') ?>">
                        <?= htmlspecialchars($t['titulo']) ?>
                    </div>
                    <?php if (!empty($t['nome_crianca'])): ?>
                        <span class="tag"><?= htmlspecialchars($t['nome_crianca']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($horarioFormatado)): ?>
                        <div class="task-meta"><?= htmlspecialchars($horarioFormatado) ?></div>
                    <?php endif; ?>
                    <div class="task-row-actions">
                        <button title="Editar" onclick="abrirModalTarefa(<?= $jsonDados ?>)">
                            <svg><use href="#i-pencil" /></svg>
                        </button>
                        <button title="Excluir" class="btn-del" onclick="confirmarExclusao('Excluir Tarefa', 'Deseja realmente remover a tarefa \'<?= addslashes(htmlspecialchars($t['titulo'])) ?>\'?', 'index.php?pagina=tarefas&acao=deletar_tarefa&id=<?= $t['id'] ?>')">
                            <svg><use href="#i-trash" /></svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- SEÇÃO CONCLUÍDAS -->
    <p class="task-section-title">Concluídas</p>
    <div class="task-list-panel" id="tarefas-concluidas-panel">
        <?php if (empty($tarefasConcluidas)): ?>
            <div style="padding:16px 0;color:var(--ink-faint);font-size:13.5px;text-align:center;">
                Nenhuma tarefa concluída no momento.
            </div>
        <?php else: ?>
            <?php foreach ($tarefasConcluidas as $t): ?>
                <?php
                $jsonDados = htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8');
                $horarioFormatado = '';
                if (!empty($t['horario'])) {
                    $partesH = explode(':', $t['horario']);
                    $horarioFormatado = $partesH[1] == '00' ? $partesH[0] . 'h' : $partesH[0] . 'h' . $partesH[1];
                }
                ?>
                <div class="task-item done" data-id="<?= $t['id'] ?>">
                    <div class="task-check" onclick="toggleTask(this, <?= $t['id'] ?>)" title="Reabrir tarefa">
                        <svg><use href="#i-check" /></svg>
                    </div>
                    <div class="task-title" title="<?= htmlspecialchars($t['observacoes'] ?? '') ?>">
                        <?= htmlspecialchars($t['titulo']) ?>
                    </div>
                    <?php if (!empty($t['nome_crianca'])): ?>
                        <span class="tag"><?= htmlspecialchars($t['nome_crianca']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($horarioFormatado)): ?>
                        <div class="task-meta"><?= htmlspecialchars($horarioFormatado) ?></div>
                    <?php endif; ?>
                    <div class="task-row-actions">
                        <button title="Editar" onclick="abrirModalTarefa(<?= $jsonDados ?>)">
                            <svg><use href="#i-pencil" /></svg>
                        </button>
                        <button title="Excluir" class="btn-del" onclick="confirmarExclusao('Excluir Tarefa', 'Deseja realmente remover a tarefa \'<?= addslashes(htmlspecialchars($t['titulo'])) ?>\'?', 'index.php?pagina=tarefas&acao=deletar_tarefa&id=<?= $t['id'] ?>')">
                            <svg><use href="#i-trash" /></svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- ================= MODAL CADASTRAR / EDITAR TAREFA ================= -->
<div class="modal-overlay hidden" id="modal-tarefa">
    <div class="modal">
        <div class="modal-head">
            <h3 id="modal-tarefa-title">Nova Tarefa</h3>
            <button type="button" class="modal-close" onclick="fecharModal('modal-tarefa')">
                <svg><use href="#i-x" /></svg>
            </button>
        </div>
        <form id="form-tarefa" action="index.php?pagina=tarefas&acao=cadastrar_tarefa" method="POST">
            <input type="hidden" name="id" id="tarefa-id">

            <div class="field">
                <label for="tarefa-titulo">Título da Tarefa</label>
                <input id="tarefa-titulo" name="titulo" placeholder="Ex: Administrar remédio antialérgico" required>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="tarefa-crianca-id">Criança (opcional)</label>
                    <select id="tarefa-crianca-id" name="crianca_id">
                        <option value="">Geral / Todas</option>
                        <?php foreach ($listaCriancas as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="tarefa-horario">Horário (opcional)</label>
                    <input type="time" id="tarefa-horario" name="horario">
                </div>
            </div>

            <div class="field">
                <label for="tarefa-observacoes">Instruções / Observações</label>
                <textarea id="tarefa-observacoes" name="observacoes" placeholder="Detalhes de dosagem, local, etc..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-tarefa')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
