<?php
session_start();

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/Cuidadora.php';
require_once __DIR__ . '/../app/models/Crianca.php';
require_once __DIR__ . '/../app/models/Responsavel.php';
require_once __DIR__ . '/../app/models/Tarefa.php';
require_once __DIR__ . '/../app/models/Pagamento.php';

$database = new Database();
$db = $database->getConnection();

$logado = $_SESSION['logado'] ?? false;
$pagina = $_GET['pagina'] ?? 'dashboard';
$acao = $_GET['acao'] ?? '';

// --- AUTENTICAÇÃO ---
if ($acao === 'fazer_login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $cuidadora = new Cuidadora($db);
    $cuidadora->email = $_POST['email'] ?? '';
    $cuidadora->senha = $_POST['senha'] ?? '';

    if ($cuidadora->fazerLogin()) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $cuidadora->id;
        $_SESSION['usuario_nome'] = $cuidadora->nome;
        header('Location: index.php');
        exit;
    } else {
        header('Location: index.php?erro=1');
        exit;
    }
}

if ($acao === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (!$logado) {
    require_once __DIR__ . '/../app/views/layouts/header.php';
    require_once __DIR__ . '/../app/views/auth/login.php';
    require_once __DIR__ . '/../app/views/layouts/footer.php';
    exit;
}

// --- PROCESSAR CADASTROS DOS MODAIS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($acao === 'cadastrar_crianca') {
        $c = new Crianca($db);
        $c->nome = $_POST['nome'];
        $c->responsavel_id = $_POST['responsavel_id'];
        $c->data_nasc = $_POST['data_nasc'];
        $c->data_inicio = $_POST['data_inicio'];
        $c->alergias = $_POST['alergias'] ?? '';
        $c->restricoes_alimentares = $_POST['restricoes_alimentares'] ?? '';
        $c->observacoes_gerais = $_POST['observacoes_gerais'] ?? '';
        $c->cadastrar();
        header('Location: index.php?pagina=criancas&msg=sucesso');
        exit;
    }

    if ($acao === 'cadastrar_responsavel') {
        $r = new Responsavel($db);
        $r->nome = $_POST['nome'];
        $r->telefone = $_POST['telefone'];
        $r->email = $_POST['email'] ?? '';
        $r->parentesco = $_POST['parentesco'] ?? '';
        $r->e_principal = isset($_POST['e_principal']) ? 1 : 0;
        $r->cadastrar();
        header('Location: index.php?pagina=responsaveis&msg=sucesso');
        exit;
    }

    if ($acao === 'cadastrar_tarefa') {
        $t = new Tarefa($db);
        $t->cuidadora_id = $_SESSION['usuario_id'];
        $t->crianca_id = $_POST['crianca_id'] ?? null;
        $t->titulo = $_POST['titulo'];
        $t->horario = $_POST['horario'];
        $t->observacoes = $_POST['observacoes'] ?? '';
        $t->cadastrar();
        header('Location: index.php?pagina=tarefas&msg=sucesso');
        exit;
    }

    if ($acao === 'cadastrar_pagamento') {
        $p = new Pagamento($db);
        $p->responsavel_id = $_POST['responsavel_id'];
        $p->crianca_id = $_POST['crianca_id'] ?? null;
        $p->valor = $_POST['valor'];
        $p->data_vencimento = $_POST['data_vencimento'];
        $p->status = $_POST['status'];
        $p->cadastrar();
        header('Location: index.php?pagina=pagamentos&msg=sucesso');
        exit;
    }
}

// Carregar dados para renderizar nas views
$responsavelModel = new Responsavel($db);
$criancaModel = new Crianca($db);
$tarefaModel = new Tarefa($db);
$pagamentoModel = new Pagamento($db);

$listaResponsaveis = $responsavelModel->listar()->fetchAll(PDO::FETCH_ASSOC);
$listaCriancas = $criancaModel->listar()->fetchAll(PDO::FETCH_ASSOC);
$listaTarefas = $tarefaModel->listarPorCuidadora($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);
$listaPagamentos = $pagamentoModel->listar()->fetchAll(PDO::FETCH_ASSOC);

?>
<?php require_once __DIR__ . '/../app/views/layouts/header.php'; ?>
<div id="app-shell">
    <?php require_once __DIR__ . '/../app/views/layouts/sidebar.php'; ?>
    <div class="main-col">
        <?php require_once __DIR__ . '/../app/views/layouts/topbar.php'; ?>
        <main class="content-area">
            <?php
            switch ($pagina) {
                case 'criancas':
                    require_once __DIR__ . '/../app/views/criancas/index.php';
                    break;
                case 'responsaveis':
                    require_once __DIR__ . '/../app/views/responsaveis/index.php';
                    break;
                case 'tarefas':
                    require_once __DIR__ . '/../app/views/tarefas/index.php';
                    break;
                case 'pagamentos':
                    require_once __DIR__ . '/../app/views/pagamentos/index.php';
                    break;
                case 'perfil':
                    require_once __DIR__ . '/../app/views/perfil/index.php';
                    break;
                case 'dashboard':
                default:
                    require_once __DIR__ . '/../app/views/dashboard/index.php';
                    break;
            }
            ?>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../app/views/layouts/footer.php'; ?>