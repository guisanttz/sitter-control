<?php
class Responsavel
{
    private $conn;
    private $table_name = "responsaveis";

    public $id;
    public $nome;
    public $parentesco;
    public $telefone;
    public $email;
    public $endereco;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Listar todos os responsáveis com nomes das crianças vinculadas
    public function listar()
    {
        $query = "SELECT r.*, GROUP_CONCAT(c.nome SEPARATOR ', ') as criancas_nomes, COUNT(c.id) as total_criancas 
                  FROM " . $this->table_name . " r
                  LEFT JOIN criancas c ON c.responsavel_id = r.id
                  GROUP BY r.id
                  ORDER BY r.nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar responsável por ID
    public function buscarPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cadastrar novo responsável
    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome = :nome, 
                      parentesco = :parentesco, 
                      telefone = :telefone, 
                      email = :email, 
                      endereco = :endereco";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->parentesco = htmlspecialchars(strip_tags($this->parentesco ?? ''));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone ?? ''));
        $this->email = htmlspecialchars(strip_tags($this->email ?? ''));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco ?? ''));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":parentesco", $this->parentesco);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);

        return $stmt->execute();
    }

    // Atualizar responsável
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, 
                      parentesco = :parentesco, 
                      telefone = :telefone, 
                      email = :email, 
                      endereco = :endereco
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = (int)$this->id;
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->parentesco = htmlspecialchars(strip_tags($this->parentesco ?? ''));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone ?? ''));
        $this->email = htmlspecialchars(strip_tags($this->email ?? ''));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco ?? ''));

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":parentesco", $this->parentesco);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);

        return $stmt->execute();
    }

    // Deletar responsável
    public function deletar($id)
    {
        // Verificar se existem crianças vinculadas
        $check = $this->conn->prepare("SELECT COUNT(*) FROM criancas WHERE responsavel_id = :id");
        $check->bindParam(":id", $id, PDO::PARAM_INT);
        $check->execute();
        if ($check->fetchColumn() > 0) {
            return 'vinculado_crianca';
        }

        // Deletar pagamentos associados ou verificar
        $delPag = $this->conn->prepare("DELETE FROM pagamentos WHERE responsavel_id = :id");
        $delPag->bindParam(":id", $id, PDO::PARAM_INT);
        $delPag->execute();

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute() ? 'sucesso' : 'erro';
    }
}
