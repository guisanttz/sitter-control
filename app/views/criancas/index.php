<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Cuidadora - Crianças</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="bi bi-heart-fill me-2"></i>Tech Care - Cuidadora</a>
        </div>
    </nav>

    <div class="container pb-5">

        <!-- Feedback da Ação -->
        <?php if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'sucesso'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>Criança cadastrada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['mensagem']) && $_GET['mensagem'] === 'erro'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Erro ao cadastrar a criança. Verifique os dados.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-people-fill text-primary me-2"></i>Crianças Cadastradas</h2>
            <!-- Botão para abrir Modal de Cadastro -->
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaCrianca">
                <i class="bi bi-plus-lg me-1"></i> Nova Criança
            </button>
        </div>

        <!-- Tabela de Listagem -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Responsável</th>
                                <th>Data Nasc.</th>
                                <th>Período</th>
                                <th>Alergias / Restrições</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($criancas)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Nenhuma criança cadastrada até o momento.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($criancas as $c): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($c['nome']) ?></td>
                                        <td><?= htmlspecialchars($c['nome_responsavel'] ?? 'N/A') ?></td>
                                        <td><?= date('d/m/Y', strtotime($c['data_nasc'])) ?></td>
                                        <td>
                                            <small class="badge bg-info text-dark">
                                                <?= date('d/m/Y', strtotime($c['data_inicio'])) ?>
                                                <?= !empty($c['data_termino']) ? ' até ' . date('d/m/Y', strtotime($c['data_termino'])) : ' (Contínuo)' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if (!empty($c['alergias'])): ?>
                                                <span class="badge bg-danger"><i class="bi bi-shield-exclamation me-1"></i><?= htmlspecialchars($c['alergias']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($c['restricoes_alimentares'])): ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-egg-fried me-1"></i><?= htmlspecialchars($c['restricoes_alimentares']) ?></span>
                                            <?php endif; ?>
                                            <?php if (empty($c['alergias']) && empty($c['restricoes_alimentares'])): ?>
                                                <span class="text-muted small">Nenhuma</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Formuário de Cadastro -->
    <div class="modal fade" id="modalNovaCrianca" tabindex="-1" aria-labelledby="modalNovaCriancaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="index.php?acao=salvar" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalNovaCriancaLabel"><i class="bi bi-person-plus me-2"></i>Cadastrar Nova Criança</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required placeholder="Ex: Lucas Silva">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ID do Responsável</label>
                                <input type="number" name="responsavel_id" class="form-control" value="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date" name="data_nasc" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Data de Início</label>
                                <input type="date" name="data_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Data de Término (Opcional)</label>
                                <input type="date" name="data_termino" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alergias</label>
                                <textarea name="alergias" class="form-control" rows="2" placeholder="Ex: Acaros, Dipirona, Picada de inseto..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Restrições Alimentares</label>
                                <textarea name="restricoes_alimentares" class="form-control" rows="2" placeholder="Ex: Intolerância a lactose, Glúten..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Observações Gerais</label>
                                <textarea name="observacoes_gerais" class="form-control" rows="2" placeholder="Horário do cochilo, rotinas específicas..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Salvar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (com Popper para Modais funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>