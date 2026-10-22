<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Cuidadora.php';

class PerfilController
{
    private $db;
    private $cuidadoraModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->cuidadoraModel = new Cuidadora($this->db);
    }

    /**
     * Carrega os dados do perfil para exibição
     */
    public function carregarPerfil($usuario_id)
    {
        return $this->cuidadoraModel->buscarPorId($usuario_id);
    }

    /**
     * Processa a atualização dos dados do perfil
     */
    public function atualizarPerfil($usuario_id)
    {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');

        if (empty($nome) || empty($email)) {
            return 'campos_obrigatorios';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'email_invalido';
        }

        $this->cuidadoraModel->id = $usuario_id;
        $this->cuidadoraModel->nome = $nome;
        $this->cuidadoraModel->email = $email;
        $this->cuidadoraModel->telefone = $telefone;

        $resultado = $this->cuidadoraModel->atualizarPerfil();
        if ($resultado === 'sucesso') {
            return 'perfil_atualizado';
        } elseif ($resultado === 'email_em_uso') {
            return 'email_em_uso';
        }
        return 'erro_perfil';
    }

    /**
     * Processa a alteração de senha
     */
    public function alterarSenha($usuario_id)
    {
        $senhaAtual = $_POST['senha_atual'] ?? '';
        $novaSenha = $_POST['nova_senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        // Validações
        if (empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
            return 'campos_vazios';
        }

        if ($novaSenha !== $confirmarSenha) {
            return 'senhas_diferentes';
        }

        if (strlen($novaSenha) < 6) {
            return 'senha_curta';
        }

        $this->cuidadoraModel->id = $usuario_id;
        return $this->cuidadoraModel->alterarSenha($senhaAtual, $novaSenha);
    }
}
