<?php
$mesAtualNome = [
    '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março', '04' => 'abril',
    '05' => 'maio', '06' => 'junho', '07' => 'julho', '08' => 'agosto',
    '09' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
][date('m')];
?>

<div class="list-head">
    <div class="summary-row" style="flex:1;">
        <div class="stat-panel">
            <div class="icon-wrap">
                <svg><use href="#i-wallet" /></svg>
            </div>
            <div class="num">R$ <?= number_format($totaisPagamentos['total_mes'] ?? 0, 2, ',', '.') ?></div>
            <div class="lbl">Recebido em <?= $mesAtualNome ?></div>
        </div>
        <div class="stat-panel gold">
            <div class="icon-wrap">
                <svg><use href="#i-clock" /></svg>
            </div>
            <div class="num">R$ <?= number_format($totaisPagamentos['total_pendente'] ?? 0, 2, ',', '.') ?></div>
            <div class="lbl">Total pendente</div>
        </div>
        <div class="stat-panel">
            <div class="icon-wrap" style="background:var(--surface-soft);">
                <svg style="stroke:var(--ink-soft);"><use href="#i-calendar" /></svg>
            </div>
            <div class="num">R$ <?= number_format($totaisPagamentos['total_agendado'] ?? 0, 2, ',', '.') ?></div>
            <div class="lbl">Agendado</div>
        </div>
    </div>
</div>

<div class="list-head">
    <div class="search-inline">
        <svg><use href="#i-search" /></svg>
        <input id="busca-pagamentos" placeholder="Buscar por responsável ou criança...">
    </div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="abrirModalPagamento()">
            <svg><use href="#i-plus" /></svg>Novo pagamento
        </button>
    </div>
</div>

<?php if (empty($listaPagamentos)): ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg><use href="#i-wallet" /></svg>
        </div>
        <h4>Nenhum pagamento registrado</h4>
        <p>Acompanhe mensalidades, valores pendentes e histórico financeiro dos serviços.</p>
        <button class="btn btn-primary" style="width:auto;margin-top:8px;" onclick="abrirModalPagamento()">
            <svg><use href="#i-plus" /></svg>Registrar primeiro pagamento
        </button>
    </div>
<?php else: ?>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Vencimento</th>
                    <th>Responsável</th>
                    <th>Criança</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaPagamentos as $p): ?>
                    <?php
                    $jsonDados = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
                    $dataVenc = !empty($p['data_vencimento']) ? date('d/m/Y', strtotime($p['data_vencimento'])) : '—';
                    $valorFmt = 'R$ ' . number_format($p['valor'] ?? 0, 2, ',', '.');
                    
                    $badgeClass = 'badge-gold';
                    if ($p['status'] === 'Pago') $badgeClass = 'badge-green';
                    elseif ($p['status'] === 'Agendado') $badgeClass = 'badge-gray';
                    ?>
                    <tr>
                        <td style="font-weight:600;color:var(--ink);">
                            <?= $dataVenc ?>
                        </td>
                        <td>
                            <div style="font-weight:700;"><?= htmlspecialchars($p['nome_responsavel'] ?? 'Não informado') ?></div>
                        </td>
                        <td>
                            <?= htmlspecialchars($p['nome_crianca'] ?: '—') ?>
                        </td>
                        <td style="font-weight:700;font-family:'Fraunces',serif;font-size:15px;color:var(--ink);">
                            <?= $valorFmt ?>
                        </td>
                        <td>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($p['status']) ?></span>
                        </td>
                        <td style="text-align:right;">
                            <div class="row-actions" style="justify-content:flex-end;">
                                <button title="Editar" onclick="abrirModalPagamento(<?= $jsonDados ?>)">
                                    <svg><use href="#i-pencil" /></svg>
                                </button>
                                <button title="Excluir" class="btn-del" onclick="confirmarExclusao('Excluir Pagamento', 'Deseja realmente remover este pagamento de <?= $valorFmt ?>?', 'index.php?pagina=pagamentos&acao=deletar_pagamento&id=<?= $p['id'] ?>')">
                                    <svg><use href="#i-trash" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!-- ================= MODAL CADASTRAR / EDITAR PAGAMENTO ================= -->
<div class="modal-overlay hidden" id="modal-pagamento">
    <div class="modal">
        <div class="modal-head">
            <h3 id="modal-pagamento-title">Novo Pagamento</h3>
            <button type="button" class="modal-close" onclick="fecharModal('modal-pagamento')">
                <svg><use href="#i-x" /></svg>
            </button>
        </div>
        <form id="form-pagamento" action="index.php?pagina=pagamentos&acao=cadastrar_pagamento" method="POST">
            <input type="hidden" name="id" id="pag-id">

            <div class="grid-2">
                <div class="field">
                    <label for="pag-responsavel-id">Responsável Financeiro</label>
                    <select id="pag-responsavel-id" name="responsavel_id" required>
                        <option value="">Selecione o responsável</option>
                        <?php foreach ($listaResponsaveis as $resp): ?>
                            <option value="<?= $resp['id'] ?>"><?= htmlspecialchars($resp['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="pag-crianca-id">Criança (opcional)</label>
                    <select id="pag-crianca-id" name="crianca_id">
                        <option value="">Nenhuma / Geral</option>
                        <?php foreach ($listaCriancas as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="pag-valor">Valor (R$)</label>
                    <input type="number" step="0.01" min="0" id="pag-valor" name="valor" placeholder="0,00" required>
                </div>
                <div class="field">
                    <label for="pag-data-vencimento">Data de Vencimento</label>
                    <input type="date" id="pag-data-vencimento" name="data_vencimento" required>
                </div>
            </div>

            <div class="field">
                <label for="pag-status">Status do Pagamento</label>
                <select id="pag-status" name="status" required>
                    <option value="Pendente">Pendente</option>
                    <option value="Pago">Pago</option>
                    <option value="Agendado">Agendado</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-pagamento')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
