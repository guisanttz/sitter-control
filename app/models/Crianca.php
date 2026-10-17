<?php
class Crianca
{
    private $conn;
    private $table_name = "criancas";

    // Propriedades declaradas explicitamente para evitar avisos
    public $id;
    public $responsavel_id;
    public $nome;
    public $data_nasc;
    public $data_inicio;
    public $data_termino;
    public $alergias;
    public $restricoes_alimentares;
    public $observacoes_gerais;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para listar todas as crianças
    public function listar()
    {
        $query = "SELECT c.*, r.nome as nome_responsavel 
                  FROM " . $this->table_name . " c
                  JOIN responsaveis r ON c.responsavel_id = r.id
                  ORDER BY c.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para cadastrar uma nova criança
    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET responsavel_id = :responsavel_id, 
                      nome = :nome, 
                      data_nasc = :data_nasc, 
                      data_inicio = :data_inicio, 
                      data_termino = :data_termino, 
                      alergias = :alergias, 
                      restricoes_alimentares = :restricoes_alimentares, 
                      observacoes_gerais = :observacoes_gerais";

        $stmt = $this->conn->prepare($query);

        // Tratamento seguro (coalesce ?? '') para evitar passar null para o strip_tags
        $this->responsavel_id = htmlspecialchars(strip_tags($this->responsavel_id ?? ''));
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->data_nasc = htmlspecialchars(strip_tags($this->data_nasc ?? ''));
        $this->data_inicio = htmlspecialchars(strip_tags($this->data_inicio ?? ''));
        $this->data_termino = !empty($this->data_termino) ? htmlspecialchars(strip_tags($this->data_termino)) : null;
        $this->alergias = htmlspecialchars(strip_tags($this->alergias ?? ''));
        $this->restricoes_alimentares = htmlspecialchars(strip_tags($this->restricoes_alimentares ?? ''));
        $this->observacoes_gerais = htmlspecialchars(strip_tags($this->observacoes_gerais ?? ''));

        // Vinculando parâmetros aos placeholders
        $stmt->bindParam(":responsavel_id", $this->responsavel_id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":data_nasc", $this->data_nasc);
        $stmt->bindParam(":data_inicio", $this->data_inicio);
        $stmt->bindParam(":data_termino", $this->data_termino);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":restricoes_alimentares", $this->restricoes_alimentares);
        $stmt->bindParam(":observacoes_gerais", $this->observacoes_gerais);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
