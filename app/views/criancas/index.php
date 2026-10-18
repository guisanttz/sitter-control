<div class="list-head">
    <div class="search-inline"><svg>
            <use href="#i-search" />
        </svg><input placeholder="Buscar criança..."></div>
    <div class="head-actions">
        <button class="btn btn-primary" onclick="openModal('crianca')"><svg>
                <use href="#i-plus" />
            </svg>Nova criança</button>
    </div>
</div>
<div class="child-grid">
    <div class="child-card">
        <div class="child-card-top">
            <div class="child-id">
                <div class="avatar">SA</div>
                <div>
                    <div class="child-name">Sofia Almeida</div>
                    <div class="child-age">4 anos</div>
                </div>
            </div>
            <div class="card-icon-actions"><button onclick="openModal('crianca')"><svg>
                        <use href="#i-pencil" />
                    </svg></button><button><svg>
                        <use href="#i-trash" />
                    </svg></button></div>
        </div>
        <div class="child-card-body">
            <span class="badge badge-green" style="width:fit-content;">Ativa</span>
            <div class="allergy-line"><svg>
                    <use href="#i-alert" />
                </svg>Alergia a amendoim</div>
        </div>
        <div class="child-card-foot">Sob cuidados desde 10/02/2023</div>
    </div>

    <div class="child-card">
        <div class="child-card-top">
            <div class="child-id">
                <div class="avatar">MT</div>
                <div>
                    <div class="child-name">Miguel Torres</div>
                    <div class="child-age">2 anos</div>
                </div>
            </div>
            <div class="card-icon-actions"><button onclick="openModal('crianca')"><svg>
                        <use href="#i-pencil" />
                    </svg></button><button><svg>
                        <use href="#i-trash" />
                    </svg></button></div>
        </div>
        <div class="child-card-body">
            <span class="badge badge-green" style="width:fit-content;">Ativa</span>
        </div>
        <div class="child-card-foot">Sob cuidados desde 03/06/2024</div>
    </div>
</div>
<!-- Modal Cadastrar Criança -->
<div class="modal-overlay hidden" id="modal-crianca">
    <div class="modal">
        <div class="modal-head">
            <h3>Nova Criança</h3>
            <button type="button" class="modal-close" onclick="fecharModal('modal-crianca')"><svg>
                    <use href="#i-x" />
                </svg></button>
        </div>
        <form action="index.php?acao=cadastrar_crianca" method="POST">
            <div class="field">
                <label>Nome Completo</label>
                <input name="nome" placeholder="Nome da criança" required>
            </div>
            <div class="field">
                <label>Responsável</label>
                <select name="responsavel_id" required>
                    <option value="">Selecione um responsável</option>
                    <?php foreach ($listaResponsaveis as $resp): ?>
                        <option value="<?= $resp['id'] ?>"><?= htmlspecialchars($resp['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid-2">
                <div class="field"><label>Data Nascimento</label><input type="date" name="data_nasc" required></div>
                <div class="field"><label>Data Início</label><input type="date" name="data_inicio" required></div>
            </div>
            <div class="field"><label>Alergias</label><textarea name="alergias" placeholder="Ex: amendoim, poeira..."></textarea></div>
            <div class="field"><label>Restrições Alimentares</label><textarea name="restricoes_alimentares" placeholder="Ex: sem lactose"></textarea></div>
            <div class="field"><label>Observações Gerais</label><textarea name="observacoes_gerais" placeholder="Comportamento, hábitos..."></textarea></div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal('modal-crianca')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div> 