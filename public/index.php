<?php
session_start();

// Simulação simples de controlo de sessão para o login
$logado = $_SESSION['logado'] ?? false;
$pagina = $_GET['pagina'] ?? 'dashboard';

// Ação de login simples para teste (quando submeter o formulário)
if (isset($_GET['acao']) && $_GET['acao'] === 'fazer_login') {
    $_SESSION['logado'] = true;
    header('Location: index.php');
    exit;
}

// Ação de logout
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    $_SESSION['logado'] = false;
    header('Location: index.php');
    exit;
}

if (!$logado) {
    // Carrega o header (que tem o link do CSS) e depois a view de login
    require_once __DIR__ . '/../app/views/layouts/header.php';
    require_once __DIR__ . '/../app/views/auth/login.php';
    require_once __DIR__ . '/../app/views/layouts/footer.php';
    exit;
}
?>
<!-- Se estiver logado, carrega o App Shell completo -->
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