<?php
class Cuidadora {
    private $conn;
    private $table_name = "cuidadoras";

    public $id;
    public $nome;
    public $email;
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
}
?>