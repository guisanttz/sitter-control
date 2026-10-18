<?php
class Pagamento
{
    private $conn;
    private $table_name = "pagamentos";

    public $id;
    public $responsavel_id;
    public $crianca_id;
    public $valor;
    public $data_vencimento;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function listar()
    {
        $query = "SELECT p.*, r.nome as nome_responsavel, c.nome as nome_crianca 
                  FROM " . $this->table_name . " p
                  JOIN responsaveis r ON p.responsavel_id = r.id
                  LEFT JOIN criancas c ON p.crianca_id = c.id
                  ORDER BY p.data_vencimento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET responsavel_id = :responsavel_id, crianca_id = :crianca_id, valor = :valor, data_vencimento = :data_vencimento, status = :status";
        $stmt = $this->conn->prepare($query);

        $this->crianca_id = !empty($this->crianca_id) ? $this->crianca_id : null;

        $stmt->bindParam(":responsavel_id", $this->responsavel_id);
        $stmt->bindParam(":crianca_id", $this->crianca_id);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":data_vencimento", $this->data_vencimento);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }
}
