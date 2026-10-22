<?php
class Tarefa
{
    private $conn;
    private $table_name = "tarefas";

    public $id;
    public $cuidadora_id;
    public $crianca_id;
    public $titulo;
    public $horario;
    public $observacoes;
    public $concluida;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Listar tarefas da cuidadora ordenadas por status e horário
    public function listarPorCuidadora($cuidadora_id)
    {
        $query = "SELECT t.*, c.nome as nome_crianca 
                  FROM " . $this->table_name . " t
                  LEFT JOIN criancas c ON t.crianca_id = c.id
                  WHERE t.cuidadora_id = :cuidadora_id
                  ORDER BY t.concluida ASC, t.horario ASC, t.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cuidadora_id", $cuidadora_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Buscar tarefa por ID
    public function buscarPorId($id)
    {
        $query = "SELECT t.*, c.nome as nome_crianca 
                  FROM " . $this->table_name . " t
                  LEFT JOIN criancas c ON t.crianca_id = c.id
                  WHERE t.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cadastrar nova tarefa
    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET cuidadora_id = :cuidadora_id, 
                      crianca_id = :crianca_id, 
                      titulo = :titulo, 
                      horario = :horario, 
                      observacoes = :observacoes,
                      concluida = :concluida";
        $stmt = $this->conn->prepare($query);

        $this->cuidadora_id = (int)$this->cuidadora_id;
        $this->crianca_id = !empty($this->crianca_id) ? (int)$this->crianca_id : null;
        $this->titulo = htmlspecialchars(strip_tags($this->titulo ?? ''));
        $this->horario = !empty($this->horario) ? $this->horario : null;
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes ?? ''));
        $this->concluida = !empty($this->concluida) ? 1 : 0;

        $stmt->bindParam(":cuidadora_id", $this->cuidadora_id, PDO::PARAM_INT);
        $stmt->bindParam(":crianca_id", $this->crianca_id, PDO::PARAM_INT);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":horario", $this->horario);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":concluida", $this->concluida, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Atualizar tarefa
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET crianca_id = :crianca_id, 
                      titulo = :titulo, 
                      horario = :horario, 
                      observacoes = :observacoes
                  WHERE id = :id AND cuidadora_id = :cuidadora_id";
        $stmt = $this->conn->prepare($query);

        $this->id = (int)$this->id;
        $this->cuidadora_id = (int)$this->cuidadora_id;
        $this->crianca_id = !empty($this->crianca_id) ? (int)$this->crianca_id : null;
        $this->titulo = htmlspecialchars(strip_tags($this->titulo ?? ''));
        $this->horario = !empty($this->horario) ? $this->horario : null;
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes ?? ''));

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":cuidadora_id", $this->cuidadora_id, PDO::PARAM_INT);
        $stmt->bindParam(":crianca_id", $this->crianca_id, PDO::PARAM_INT);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":horario", $this->horario);
        $stmt->bindParam(":observacoes", $this->observacoes);

        return $stmt->execute();
    }

    // Alternar status de conclusão
    public function toggleConcluida($id)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET concluida = IF(concluida = 1, 0, 1) 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $stmtStatus = $this->conn->prepare("SELECT concluida FROM " . $this->table_name . " WHERE id = :id");
            $stmtStatus->bindParam(":id", $id, PDO::PARAM_INT);
            $stmtStatus->execute();
            return $stmtStatus->fetchColumn();
        }
        return false;
    }

    // Deletar tarefa
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
