<div class="list-head">
    <div class="search-inline">
        <svg><use href="#i-search" /></svg>
        <input id="busca-criancas" placeholder="Buscar criança pelo nome...">
    </div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="abrirModalCrianca()">
            <svg><use href="#i-plus" /></svg>Nova criança
        </button>
    </div>
</div>

<?php if (empty($listaCriancas)): ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg><use href="#i-smile" /></svg>
        </div>
        <h4>Nenhuma criança cadastrada</h4>
        <p>Cadastre as crianças sob seus cuidados para acompanhar rotinas, contatos e alergias.</p>
        <button class="btn btn-primary" style="width:auto;margin-top:8px;" onclick="abrirModalCrianca()">
            <svg><use href="#i-plus" /></svg>Cadastrar primeira criança
        </button>
    </div>
<?php else: ?>
    <div class="child-grid">
        <?php foreach ($listaCriancas as $c): ?>
            <?php
            // Gerar iniciais do nome
            $iniciais = 'CR';
            if (!empty($c['nome'])) {
                $partes = preg_split('/\s+/', trim($c['nome']));
                $iniciais = mb_strtoupper(mb_substr($partes[0], 0, 1));
                if (count($partes) > 1) {
                    $iniciais .= mb_strtoupper(mb_substr(end($partes), 0, 1));
                }
            }

            // Calcular idade
            $idadeTexto = Crianca::calcularIdade($c['data_nasc']);

            // Status (ativa / inativa)
            $ativa = empty($c['data_termino']) || (strtotime($c['data_termino']) >= strtotime(date('Y-m-d')));

            // Preparar dados para o modal de edição em JSON seguro
            $jsonDados = htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8');
            ?>
            <div class="child-card">
                <div class="child-card-top">
                    <div class="child-id">
                        <div class="avatar"><?= htmlspecialchars($iniciais) ?></div>
                        <div>
                            <div class="child-name"><?= htmlspecialchars($c['nome']) ?></div>
                            <div class="child-age"><?= htmlspecialchars($idadeTexto) ?></div>
                        </div>
                    </div>
                    <div class="card-icon-actions">
                        <button title="Editar" onclick="abrirModalCrianca(<?= $jsonDados ?>)">
                            <svg><use href="#i-pencil" /></svg>
                        </button>
                        <button title="Excluir" class="btn-del" onclick="confirmarExclusao('Excluir Criança', 'Deseja realmente remover o cadastro de <?= addslashes(htmlspecialchars($c['nome'])) ?>? Todas as tarefas e pagamentos vinculados serão desassociados.', 'index.php?pagina=criancas&acao=deletar_crianca&id=<?= $c['id'] ?>')">
                            <svg><use href="#i-trash" /></svg>
                        </button>
                    </div>
                </div>

                <div class="child-card-body">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span class="badge <?= $ativa ? 'badge-green' : 'badge-gray' ?>">
                            <?= $ativa ? 'Ativa' : 'Encerrada' ?>
                        </span>
                        <?php if (!empty($c['nome_responsavel'])): ?>
                            <span class="tag" title="Responsável">Resp: <?= htmlspecialchars($c['nome_responsavel']) ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($c['alergias'])): ?>
                        <div class="allergy-line" title="Alergias">
                            <svg><use href="#i-alert" /></svg>
                            <span><?= htmlspecialchars($c['alergias']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($c['restricoes_alimentares'])): ?>
                        <div style="font-size:12.5px;color:var(--ink-soft);display:flex;align-items:center;gap:6px;">
                            <span style="font-weight:600;color:var(--gold);">Alimentação:</span>
                            <span><?= htmlspecialchars($c['restricoes_alimentares']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="child-card-foot">
                    Sob cuidados desde <?= !empty($c['data_inicio']) ? date('d/m/Y', strtotime($c['data_inicio'])) : 'N/I' ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- ================= MODAL CADASTRAR / EDITAR CRIANÇA ================= -->
<div class="modal-overlay hidden" id="modal-crianca">
    <div class="modal">
        <div class="modal-head">
            <h3 id="modal-crianca-title">Nova Criança</h3>
            <button type="button" class="modal-close" onclick="fecharModal('modal-crianca')">
                <svg><use href="#i-x" /></svg>
            </button>
        </div>
        <form id="form-crianca" action="index.php?pagina=criancas&acao=cadastrar_crianca" method="POST">
            <input type="hidden" name="id" id="crianca-id">

            <div class="field">
                <label for="crianca-nome">Nome Completo</label>
                <input id="crianca-nome" name="nome" placeholder="Ex: Lucas Henrique Silva" required>
            </div>

            <div class="field">
                <label for="crianca-responsavel-id">Responsável</label>
                <select id="crianca-responsavel-id" name="responsavel_id" required>
                    <option value="">Selecione um responsável</option>
                    <?php foreach ($listaResponsaveis as $resp): ?>
                        <option value="<?= $resp['id'] ?>"><?= htmlspecialchars($resp['nome']) ?> (<?= htmlspecialchars($resp['parentesco']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="crianca-data-nasc">Data de Nascimento</label>
                    <input type="date" id="crianca-data-nasc" name="data_nasc" required>
                </div>
                <div class="field">
                    <label for="crianca-data-inicio">Data de Início</label>
                    <input type="date" id="crianca-data-inicio" name="data_inicio" required>
                </div>
            </div>

            <div class="field">
                <label for="crianca-data-termino">Data de Término (opcional)</label>
                <input type="date" id="crianca-data-termino" name="data_termino">
            </div>

            <div class="field">
                <label for="crianca-alergias">Alergias</label>
                <textarea id="crianca-alergias" name="alergias" placeholder="Ex: amendoim, frutos do mar, poeira..."></textarea>
            </div>

            <div class="field">
                <label for="crianca-restricoes">Restrições Alimentares</label>
                <textarea id="crianca-restricoes" name="restricoes_alimentares" placeholder="Ex: intolerância à lactose, vegetariano..."></textarea>
            </div>

            <div class="field">
                <label for="crianca-observacoes">Observações Gerais</label>
                <textarea id="crianca-observacoes" name="observacoes_gerais" placeholder="Comportamento, preferências, rotina..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-crianca')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
