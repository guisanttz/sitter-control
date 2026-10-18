<?php
class Responsavel
{
    private $conn;
    private $table_name = "responsaveis";

    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $parentesco;
    public $e_principal;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function listar()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome = :nome, telefone = :telefone, email = :email, parentesco = :parentesco, e_principal = :e_principal";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone ?? ''));
        $this->email = htmlspecialchars(strip_tags($this->email ?? ''));
        $this->parentesco = htmlspecialchars(strip_tags($this->parentesco ?? ''));
        $this->e_principal = $this->e_principal ? 1 : 0;

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":parentesco", $this->parentesco);
        $stmt->bindParam(":e_principal", $this->e_principal);

        return $stmt->execute();
    }
}
