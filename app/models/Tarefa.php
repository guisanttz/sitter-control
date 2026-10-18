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

    public function listarPorCuidadora($cuidadora_id)
    {
        $query = "SELECT t.*, c.nome as nome_crianca 
                  FROM " . $this->table_name . " t
                  LEFT JOIN criancas c ON t.crianca_id = c.id
                  WHERE t.cuidadora_id = :cuidadora_id
                  ORDER BY t.concluida ASC, t.horario ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cuidadora_id", $cuidadora_id);
        $stmt->execute();
        return $stmt;
    }

    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET cuidadora_id = :cuidadora_id, crianca_id = :crianca_id, titulo = :titulo, horario = :horario, observacoes = :observacoes";
        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo ?? ''));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes ?? ''));
        $this->crianca_id = !empty($this->crianca_id) ? $this->crianca_id : null;

        $stmt->bindParam(":cuidadora_id", $this->cuidadora_id);
        $stmt->bindParam(":crianca_id", $this->crianca_id);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":horario", $this->horario);
        $stmt->bindParam(":observacoes", $this->observacoes);

        return $stmt->execute();
    }
}
