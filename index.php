<?php
require_once __DIR__ . '/app/config/Database.php';
require_once __DIR__ . '/app/models/Crianca.php';
require_once __DIR__ . '/app/models/Responsavel.php';
require_once __DIR__ . '/app/models/Tarefa.php';
require_once __DIR__ . '/app/models/Pagamento.php';
require_once __DIR__ . '/app/models/Cuidadora.php';
require_once __DIR__ . '/app/controllers/PerfilController.php';

$database = new Database();
$db = $database->getConnection();

$pagina = $_GET['pagina'] ?? 'dashboard';
$acao = $_GET['acao'] ?? '';

// ID fixo da cuidadora (sem autenticação)
$usuario_id = 1;

// --- PROCESSAR AÇÕES DE PERFIL ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pagina === 'perfil') {
    $perfilCtrl = new PerfilController($db);

    if ($acao === 'atualizar_perfil') {
        $resultado = $perfilCtrl->atualizarPerfil($usuario_id);
        header('Location: index.php?pagina=perfil&msg=' . $resultado);
        exit;
    }

    if ($acao === 'alterar_senha') {
        $resultado = $perfilCtrl->alterarSenha($usuario_id);
        header('Location: index.php?pagina=perfil&msg=' . $resultado);
        exit;
    }
}

// --- PROCESSAR AÇÕES DE CRIANÇAS ---
if ($acao === 'cadastrar_crianca' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = new Crianca($db);
    $c->nome = $_POST['nome'] ?? '';
    $c->responsavel_id = $_POST['responsavel_id'] ?? null;
    $c->data_nasc = $_POST['data_nasc'] ?? '';
    $c->data_inicio = $_POST['data_inicio'] ?? '';
    $c->data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
    $c->alergias = $_POST['alergias'] ?? '';
    $c->restricoes_alimentares = $_POST['restricoes_alimentares'] ?? '';
    $c->observacoes_gerais = $_POST['observacoes_gerais'] ?? '';
    
    $res = $c->cadastrar();
    header('Location: index.php?pagina=criancas&msg=' . ($res ? 'crianca_cadastrada' : 'erro'));
    exit;
}

if ($acao === 'editar_crianca' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = new Crianca($db);
    $c->id = $_POST['id'] ?? 0;
    $c->nome = $_POST['nome'] ?? '';
    $c->responsavel_id = $_POST['responsavel_id'] ?? null;
    $c->data_nasc = $_POST['data_nasc'] ?? '';
    $c->data_inicio = $_POST['data_inicio'] ?? '';
    $c->data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
    $c->alergias = $_POST['alergias'] ?? '';
    $c->restricoes_alimentares = $_POST['restricoes_alimentares'] ?? '';
    $c->observacoes_gerais = $_POST['observacoes_gerais'] ?? '';
    
    $res = $c->atualizar();
    header('Location: index.php?pagina=criancas&msg=' . ($res ? 'crianca_atualizada' : 'erro'));
    exit;
}

if ($acao === 'deletar_crianca') {
    $id = $_REQUEST['id'] ?? 0;
    $c = new Crianca($db);
    $res = $c->deletar($id);
    header('Location: index.php?pagina=criancas&msg=' . ($res ? 'crianca_excluida' : 'erro'));
    exit;
}

// --- PROCESSAR AÇÕES DE RESPONSÁVEIS ---
if ($acao === 'cadastrar_responsavel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $r = new Responsavel($db);
    $r->nome = $_POST['nome'] ?? '';
    $r->parentesco = $_POST['parentesco'] ?? '';
    $r->telefone = $_POST['telefone'] ?? '';
    $r->email = $_POST['email'] ?? '';
    $r->endereco = $_POST['endereco'] ?? '';
    
    $res = $r->cadastrar();
    header('Location: index.php?pagina=responsaveis&msg=' . ($res ? 'responsavel_cadastrado' : 'erro'));
    exit;
}

if ($acao === 'editar_responsavel' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $r = new Responsavel($db);
    $r->id = $_POST['id'] ?? 0;
    $r->nome = $_POST['nome'] ?? '';
    $r->parentesco = $_POST['parentesco'] ?? '';
    $r->telefone = $_POST['telefone'] ?? '';
    $r->email = $_POST['email'] ?? '';
    $r->endereco = $_POST['endereco'] ?? '';
    
    $res = $r->atualizar();
    header('Location: index.php?pagina=responsaveis&msg=' . ($res ? 'responsavel_atualizado' : 'erro'));
    exit;
}

if ($acao === 'deletar_responsavel') {
    $id = $_REQUEST['id'] ?? 0;
    $r = new Responsavel($db);
    $res = $r->deletar($id);
    if ($res === 'vinculado_crianca') {
        header('Location: index.php?pagina=responsaveis&msg=responsavel_com_criancas');
    } else {
        header('Location: index.php?pagina=responsaveis&msg=' . ($res === 'sucesso' ? 'responsavel_excluido' : 'erro'));
    }
    exit;
}

// --- PROCESSAR AÇÕES DE TAREFAS ---
if ($acao === 'cadastrar_tarefa' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = new Tarefa($db);
    $t->cuidadora_id = $usuario_id;
    $t->crianca_id = !empty($_POST['crianca_id']) ? $_POST['crianca_id'] : null;
    $t->titulo = $_POST['titulo'] ?? '';
    $t->horario = !empty($_POST['horario']) ? $_POST['horario'] : null;
    $t->observacoes = $_POST['observacoes'] ?? '';
    
    $res = $t->cadastrar();
    header('Location: index.php?pagina=tarefas&msg=' . ($res ? 'tarefa_cadastrada' : 'erro'));
    exit;
}

if ($acao === 'editar_tarefa' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = new Tarefa($db);
    $t->id = $_POST['id'] ?? 0;
    $t->cuidadora_id = $usuario_id;
    $t->crianca_id = !empty($_POST['crianca_id']) ? $_POST['crianca_id'] : null;
    $t->titulo = $_POST['titulo'] ?? '';
    $t->horario = !empty($_POST['horario']) ? $_POST['horario'] : null;
    $t->observacoes = $_POST['observacoes'] ?? '';
    
    $res = $t->atualizar();
    header('Location: index.php?pagina=tarefas&msg=' . ($res ? 'tarefa_atualizada' : 'erro'));
    exit;
}

if ($acao === 'toggle_tarefa') {
    $id = $_REQUEST['id'] ?? 0;
    $t = new Tarefa($db);
    $novoStatus = $t->toggleConcluida($id);
    
    // Responder com JSON se for AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode([
            'sucesso' => ($novoStatus !== false), 
            'concluida' => (int)$novoStatus
        ]);
        exit;
    }
    
    $redirecionarPara = ($pagina === 'dashboard') ? 'dashboard' : 'tarefas';
    header("Location: index.php?pagina={$redirecionarPara}&msg=tarefa_status_alterado");
    exit;
}

if ($acao === 'deletar_tarefa') {
    $id = $_REQUEST['id'] ?? 0;
    $t = new Tarefa($db);
    $res = $t->deletar($id);
    header('Location: index.php?pagina=tarefas&msg=' . ($res ? 'tarefa_excluida' : 'erro'));
    exit;
}

// --- PROCESSAR AÇÕES DE PAGAMENTOS ---
if ($acao === 'cadastrar_pagamento' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = new Pagamento($db);
    $p->responsavel_id = $_POST['responsavel_id'] ?? null;
    $p->crianca_id = !empty($_POST['crianca_id']) ? $_POST['crianca_id'] : null;
    $p->valor = $_POST['valor'] ?? 0;
    $p->data_vencimento = $_POST['data_vencimento'] ?? date('Y-m-d');
    $p->status = $_POST['status'] ?? 'Pendente';
    
    $res = $p->cadastrar();
    header('Location: index.php?pagina=pagamentos&msg=' . ($res ? 'pagamento_cadastrado' : 'erro'));
    exit;
}

if ($acao === 'editar_pagamento' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = new Pagamento($db);
    $p->id = $_POST['id'] ?? 0;
    $p->responsavel_id = $_POST['responsavel_id'] ?? null;
    $p->crianca_id = !empty($_POST['crianca_id']) ? $_POST['crianca_id'] : null;
    $p->valor = $_POST['valor'] ?? 0;
    $p->data_vencimento = $_POST['data_vencimento'] ?? date('Y-m-d');
    $p->status = $_POST['status'] ?? 'Pendente';
    
    $res = $p->atualizar();
    header('Location: index.php?pagina=pagamentos&msg=' . ($res ? 'pagamento_atualizado' : 'erro'));
    exit;
}

if ($acao === 'deletar_pagamento') {
    $id = $_REQUEST['id'] ?? 0;
    $p = new Pagamento($db);
    $res = $p->deletar($id);
    header('Location: index.php?pagina=pagamentos&msg=' . ($res ? 'pagamento_excluido' : 'erro'));
    exit;
}

// --- CARREGAR DADOS PARA AS VIEWS ---
$responsavelModel = new Responsavel($db);
$criancaModel = new Crianca($db);
$tarefaModel = new Tarefa($db);
$pagamentoModel = new Pagamento($db);
$cuidadoraModel = new Cuidadora($db);

$listaResponsaveis = $responsavelModel->listar()->fetchAll(PDO::FETCH_ASSOC);
$listaCriancas = $criancaModel->listar()->fetchAll(PDO::FETCH_ASSOC);
$listaTarefas = $tarefaModel->listarPorCuidadora($usuario_id)->fetchAll(PDO::FETCH_ASSOC);
$listaPagamentos = $pagamentoModel->listar()->fetchAll(PDO::FETCH_ASSOC);
$totaisPagamentos = $pagamentoModel->obterTotais();

$perfilDados = $cuidadoraModel->buscarPorId($usuario_id);
if (!$perfilDados) {
    $perfilDados = ['id' => $usuario_id, 'nome' => 'Silvana Santos', 'email' => '', 'telefone' => ''];
}

?>
<?php require_once __DIR__ . '/app/views/layouts/header.php'; ?>
<div id="app-shell">
    <?php require_once __DIR__ . '/app/views/layouts/sidebar.php'; ?>
    <div class="main-col">
        <?php require_once __DIR__ . '/app/views/layouts/topbar.php'; ?>
        <main class="content-area">
            <?php
            switch ($pagina) {
                case 'criancas':
                    require_once __DIR__ . '/app/views/criancas/index.php';
                    break;
                case 'responsaveis':
                    require_once __DIR__ . '/app/views/responsaveis/index.php';
                    break;
                case 'tarefas':
                    require_once __DIR__ . '/app/views/tarefas/index.php';
                    break;
                case 'pagamentos':
                    require_once __DIR__ . '/app/views/pagamentos/index.php';
                    break;
                case 'perfil':
                    require_once __DIR__ . '/app/views/perfil/index.php';
                    break;
                case 'dashboard':
                default:
                    require_once __DIR__ . '/app/views/dashboard/index.php';
                    break;
            }
            ?>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/app/views/layouts/footer.php'; ?>

