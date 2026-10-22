<?php
class Cuidadora {
    private $conn;
    private $table_name = "cuidadoras";

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar o login
    public function fazerLogin() {
        $query = "SELECT id, nome, email, senha FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Sanitização
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $senhaHash = $row['senha'];

            // Verifica se a senha digitada confere com o hash do banco
            if(password_verify($this->senha, $senhaHash)) {
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                return true;
            }
        }
        return false;
    }

    /**
     * Buscar dados do perfil por ID
     */
    public function buscarPorId($id) {
        $query = "SELECT id, nome, email, telefone FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Atualizar dados do perfil (nome, email, telefone)
     */
    public function atualizarPerfil() {
        // Verificar se o email já está em uso por outra cuidadora
        $checkQuery = "SELECT id FROM " . $this->table_name . " WHERE email = :email AND id != :id LIMIT 1";
        $checkStmt = $this->conn->prepare($checkQuery);
        $emailSanitizado = htmlspecialchars(strip_tags($this->email));
        $checkStmt->bindParam(":email", $emailSanitizado);
        $checkStmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return 'email_em_uso';
        }

        $query = "UPDATE " . $this->table_name . "
                  SET nome = :nome, email = :email, telefone = :telefone
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = $emailSanitizado;
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'sucesso';
        }
        return 'erro';
    }

    /**
     * Alterar senha (verifica a senha atual antes)
     */
    public function alterarSenha($senhaAtual, $novaSenha) {
        // Primeiro busca o hash atual
        $query = "SELECT senha FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se a senha atual está correta
            if (!password_verify($senhaAtual, $row['senha'])) {
                return 'senha_incorreta';
            }

            // Gera o hash da nova senha e atualiza
            $novoHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE " . $this->table_name . " SET senha = :senha WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(":senha", $novoHash);
            $updateStmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                return 'sucesso';
            }
        }
        return 'erro';
    }
}
?>
