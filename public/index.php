<?php
require_once __DIR__ . '/../app/controllers/CriancaController.php';

$controller = new CriancaController();

// Lê o parâmetro de ação passado na URL (ex: index.php?acao=salvar)
$acao = $_GET['acao'] ?? 'index';

switch ($acao) {
    case 'salvar':
        $controller->salvar();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
