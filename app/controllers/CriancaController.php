<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Crianca.php';

class CriancaController
{
    private $db;
    private $criancaModel;

    public function __construct()
    {
        // Instancia a conexão e o Model
        $database = new Database();
        $this->db = $database->getConnection();
        $this->criancaModel = new Crianca($this->db);
    }

    // Ação principal: carrega a lista e exibe a view
    public function index()
    {
        // Busca a lista de crianças cadastradas
        $stmt = $this->criancaModel->listar();
        $criancas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Se quiser popular um select de responsáveis na view, você buscaria aqui
        // Ex: $responsaveis = $this->responsavelModel->listar();

        // Envia os dados para a View
        require_once __DIR__ . '/../views/criancas/index.php';
    }

    // Ação para processar o formulário de cadastro (POST)
    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->criancaModel->responsavel_id = $_POST['responsavel_id'] ?? 1; // ID temporário ou vindo do select
            $this->criancaModel->nome = $_POST['nome'] ?? '';
            $this->criancaModel->data_nasc = $_POST['data_nasc'] ?? '';
            $this->criancaModel->data_inicio = $_POST['data_inicio'] ?? '';
            $this->criancaModel->data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
            $this->criancaModel->alergias = $_POST['alergias'] ?? '';
            $this->criancaModel->restricoes_alimentares = $_POST['restricoes_alimentares'] ?? '';
            $this->criancaModel->observacoes_gerais = $_POST['observacoes_gerais'] ?? '';

            if ($this->criancaModel->cadastrar()) {
                // Redireciona de volta para a lista com mensagem de sucesso
                header('Location: index.php?mensagem=sucesso');
                exit();
            } else {
                header('Location: index.php?mensagem=erro');
                exit();
            }
        }
    }
}
