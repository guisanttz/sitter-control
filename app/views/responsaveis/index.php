<div class="list-head">
    <div class="search-inline">
        <svg><use href="#i-search" /></svg>
        <input id="busca-responsaveis" placeholder="Buscar responsável pelo nome...">
    </div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="abrirModalResponsavel()">
            <svg><use href="#i-plus" /></svg>Novo responsável
        </button>
    </div>
</div>

<?php if (empty($listaResponsaveis)): ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg><use href="#i-users" /></svg>
        </div>
        <h4>Nenhum responsável cadastrado</h4>
        <p>Cadastre pais, mães ou tutores para vincular às crianças e controlar pagamentos.</p>
        <button class="btn btn-primary" style="width:auto;margin-top:8px;" onclick="abrirModalResponsavel()">
            <svg><use href="#i-plus" /></svg>Cadastrar primeiro responsável
        </button>
    </div>
<?php else: ?>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Parentesco</th>
                    <th>Criança(s) vinculada(s)</th>
                    <th>Endereço</th>
                    <th style="text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaResponsaveis as $resp): ?>
                    <?php
                    $jsonDados = htmlspecialchars(json_encode($resp), ENT_QUOTES, 'UTF-8');
                    $criancasArray = !empty($resp['criancas_nomes']) ? explode(',', $resp['criancas_nomes']) : [];
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight:700;color:var(--ink);font-size:14.5px;">
                                <?= htmlspecialchars($resp['nome']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;flex-direction:column;gap:3px;font-size:13px;">
                                <span style="font-weight:600;display:flex;align-items:center;gap:6px;">
                                    <svg style="width:13px;height:13px;stroke:var(--ink-soft);"><use href="#i-phone" /></svg>
                                    <?= htmlspecialchars($resp['telefone'] ?: 'Não informado') ?>
                                </span>
                                <?php if (!empty($resp['email'])): ?>
                                    <span style="color:var(--ink-soft);display:flex;align-items:center;gap:6px;">
                                        <svg style="width:13px;height:13px;stroke:var(--ink-soft);"><use href="#i-mail" /></svg>
                                        <?= htmlspecialchars($resp['email']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-gray"><?= htmlspecialchars($resp['parentesco'] ?: 'Responsável') ?></span>
                        </td>
                        <td>
                            <div class="tags-inline">
                                <?php if (!empty($criancasArray)): ?>
                                    <?php foreach ($criancasArray as $cNome): ?>
                                        <span class="tag"><?= htmlspecialchars(trim($cNome)) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span style="color:var(--ink-faint);font-size:12.5px;">Nenhuma</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td style="color:var(--ink-soft);font-size:13px;max-width:200px;">
                            <?= htmlspecialchars($resp['endereco'] ?: '—') ?>
                        </td>
                        <td style="text-align:right;">
                            <div class="row-actions" style="justify-content:flex-end;">
                                <button title="Editar" onclick="abrirModalResponsavel(<?= $jsonDados ?>)">
                                    <svg><use href="#i-pencil" /></svg>
                                </button>
                                <button title="Excluir" class="btn-del" onclick="confirmarExclusao('Excluir Responsável', 'Deseja realmente excluir <?= addslashes(htmlspecialchars($resp['nome'])) ?>? Só será possível se não houver crianças vinculadas.', 'index.php?pagina=responsaveis&acao=deletar_responsavel&id=<?= $resp['id'] ?>')">
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

<!-- ================= MODAL CADASTRAR / EDITAR RESPONSÁVEL ================= -->
<div class="modal-overlay hidden" id="modal-responsavel">
    <div class="modal">
        <div class="modal-head">
            <h3 id="modal-responsavel-title">Novo Responsável</h3>
            <button type="button" class="modal-close" onclick="fecharModal('modal-responsavel')">
                <svg><use href="#i-x" /></svg>
            </button>
        </div>
        <form id="form-responsavel" action="index.php?pagina=responsaveis&acao=cadastrar_responsavel" method="POST">
            <input type="hidden" name="id" id="resp-id">

            <div class="field">
                <label for="resp-nome">Nome Completo</label>
                <input id="resp-nome" name="nome" placeholder="Ex: Fernanda Almeida" required>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label for="resp-parentesco">Parentesco</label>
                    <select id="resp-parentesco" name="parentesco" required>
                        <option value="Mãe">Mãe</option>
                        <option value="Pai">Pai</option>
                        <option value="Avó">Avó</option>
                        <option value="Avô">Avô</option>
                        <option value="Tia">Tia</option>
                        <option value="Tio">Tio</option>
                        <option value="Responsável Legal">Responsável Legal</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="field">
                    <label for="resp-telefone">Telefone / WhatsApp</label>
                    <input type="tel" id="resp-telefone" name="telefone" placeholder="(00) 00000-0000" required>
                </div>
            </div>

            <div class="field">
                <label for="resp-email">E-mail</label>
                <input type="email" id="resp-email" name="email" placeholder="exemplo@email.com">
            </div>

            <div class="field">
                <label for="resp-endereco">Endereço (opcional)</label>
                <input id="resp-endereco" name="endereco" placeholder="Rua, número, bairro...">
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-responsavel')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
