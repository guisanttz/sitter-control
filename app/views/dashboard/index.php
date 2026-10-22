<?php
// Saudação com base na hora
$hora = (int)date('H');
$saudacao = 'Bom dia';
if ($hora >= 12 && $hora < 18) {
    $saudacao = 'Boa tarde';
} elseif ($hora >= 18 || $hora < 5) {
    $saudacao = 'Boa noite';
}

// Data formatada em português
$diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
$meses = [
    '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março', '04' => 'abril',
    '05' => 'maio', '06' => 'junho', '07' => 'julho', '08' => 'agosto',
    '09' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
];
$dataExtenso = $diasSemana[date('w')] . ', ' . date('j') . ' de ' . $meses[date('m')];

// Estatísticas dinâmicas
$criancasAtivas = count(array_filter($listaCriancas, fn($c) => empty($c['data_termino']) || strtotime($c['data_termino']) >= strtotime(date('Y-m-d'))));
$tarefasPendentesCount = count(array_filter($listaTarefas, fn($t) => empty($t['concluida'])));
$receitaMes = $totaisPagamentos['total_mes'] ?? 0;
?>

<div class="greeting">
    <h1><?= $saudacao ?>, <?= htmlspecialchars($perfilDados['nome'] ?? 'Cuidadora') ?>!</h1>
    <p><?= $dataExtenso ?></p>
</div>

<div class="stat-row">
    <div class="stat-panel">
        <div class="icon-wrap">
            <svg><use href="#i-smile" /></svg>
        </div>
        <div class="num"><?= $criancasAtivas ?></div>
        <div class="lbl">Crianças ativas</div>
    </div>
    <div class="stat-panel">
        <div class="icon-wrap">
            <svg><use href="#i-check-square" /></svg>
        </div>
        <div class="num" id="dash-pendentes"><?= $tarefasPendentesCount ?></div>
        <div class="lbl">Tarefas pendentes</div>
    </div>
    <div class="stat-panel gold">
        <div class="icon-wrap">
            <svg><use href="#i-wallet" /></svg>
        </div>
        <div class="num">R$ <?= number_format($receitaMes, 2, ',', '.') ?></div>
        <div class="lbl">Receita de <?= $meses[date('m')] ?></div>
    </div>
</div>

<div class="dash-grid">
    <!-- GRÁFICO RESUMO DE RECEITAS -->
    <div class="panel">
        <div class="panel-head">
            <h3>Controle Financeiro</h3>
            <a href="index.php?pagina=pagamentos">Ver pagamentos</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;margin-top:6px;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:var(--surface-soft);border-radius:var(--radius-sm);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:12px;height:12px;border-radius:50%;background:var(--primary);"></div>
                    <span style="font-size:13.5px;font-weight:600;">Recebido este mês</span>
                </div>
                <span style="font-weight:700;font-family:'Fraunces',serif;color:var(--primary-dark);font-size:16px;">
                    R$ <?= number_format($totaisPagamentos['total_mes'] ?? 0, 2, ',', '.') ?>
                </span>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:var(--gold-tint);border-radius:var(--radius-sm);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:12px;height:12px;border-radius:50%;background:var(--gold);"></div>
                    <span style="font-size:13.5px;font-weight:600;color:#A9752A;">Pendente a receber</span>
                </div>
                <span style="font-weight:700;font-family:'Fraunces',serif;color:#A9752A;font-size:16px;">
                    R$ <?= number_format($totaisPagamentos['total_pendente'] ?? 0, 2, ',', '.') ?>
                </span>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:var(--surface-soft);border-radius:var(--radius-sm);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:12px;height:12px;border-radius:50%;background:var(--ink-faint);"></div>
                    <span style="font-size:13.5px;font-weight:600;">Agendado</span>
                </div>
                <span style="font-weight:700;font-family:'Fraunces',serif;color:var(--ink-soft);font-size:16px;">
                    R$ <?= number_format($totaisPagamentos['total_agendado'] ?? 0, 2, ',', '.') ?>
                </span>
            </div>
        </div>
    </div>

    <!-- TAREFAS -->
    <div class="panel">
        <div class="panel-head">
            <h3>Tarefas de hoje</h3>
            <a href="index.php?pagina=tarefas">Ver todas</a>
        </div>
        <div id="dash-task-list">
            <?php if (empty($listaTarefas)): ?>
                <div style="padding:24px 0;text-align:center;color:var(--ink-faint);font-size:13.5px;">
                    Nenhuma tarefa cadastrada.
                </div>
            <?php else: ?>
                <?php
                $primeirasTarefas = array_slice($listaTarefas, 0, 5);
                foreach ($primeirasTarefas as $t):
                    $isDone = !empty($t['concluida']);
                    $horarioFormatado = '';
                    if (!empty($t['horario'])) {
                        $partesH = explode(':', $t['horario']);
                        $horarioFormatado = $partesH[1] == '00' ? $partesH[0] . 'h' : $partesH[0] . 'h' . $partesH[1];
                    }
                ?>
                    <div class="task-item <?= $isDone ? 'done' : '' ?>">
                        <div class="task-check" onclick="toggleTask(this, <?= $t['id'] ?>)">
                            <svg><use href="#i-check" /></svg>
                        </div>
                        <div class="task-title"><?= htmlspecialchars($t['titulo']) ?></div>
                        <?php if (!empty($horarioFormatado)): ?>
                            <div class="task-meta"><?= htmlspecialchars($horarioFormatado) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- PRÓXIMOS PAGAMENTOS -->
<div class="panel" style="margin-top:20px;">
    <div class="panel-head">
        <h3>Próximos pagamentos</h3>
        <a href="index.php?pagina=pagamentos">Ver todos</a>
    </div>
    <?php if (empty($listaPagamentos)): ?>
        <div style="padding:20px 0;text-align:center;color:var(--ink-faint);font-size:13.5px;">
            Nenhum pagamento registrado no sistema.
        </div>
    <?php else: ?>
        <table class="mini-table">
            <tbody>
                <?php
                $proximosPags = array_slice($listaPagamentos, 0, 4);
                foreach ($proximosPags as $p):
                    $badgeClass = 'badge-gold';
                    if ($p['status'] === 'Pago') $badgeClass = 'badge-green';
                    elseif ($p['status'] === 'Agendado') $badgeClass = 'badge-gray';
                    $dataFmt = !empty($p['data_vencimento']) ? date('d/m', strtotime($p['data_vencimento'])) : '';
                ?>
                    <tr>
                        <td>
                            <div class="who-name"><?= htmlspecialchars($p['nome_responsavel'] ?? 'Responsável') ?></div>
                            <div class="who-sub"><?= !empty($p['nome_crianca']) ? 'Criança: ' . htmlspecialchars($p['nome_crianca']) : 'Mensalidade' ?></div>
                        </td>
                        <td style="font-weight:700;font-family:'Fraunces',serif;">
                            R$ <?= number_format($p['valor'] ?? 0, 2, ',', '.') ?>
                        </td>
                        <td style="color:var(--ink-soft);">
                            Vence <?= $dataFmt ?>
                        </td>
                        <td>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($p['status']) ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
