<?php
class Crianca
{
    private $conn;
    private $table_name = "criancas";

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

    // Listar todas as crianças com dados do responsável
    public function listar()
    {
        $query = "SELECT c.*, r.nome as nome_responsavel, r.telefone as telefone_responsavel 
                  FROM " . $this->table_name . " c
                  LEFT JOIN responsaveis r ON c.responsavel_id = r.id
                  ORDER BY c.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar criança por ID
    public function buscarPorId($id)
    {
        $query = "SELECT c.*, r.nome as nome_responsavel 
                  FROM " . $this->table_name . " c
                  LEFT JOIN responsaveis r ON c.responsavel_id = r.id
                  WHERE c.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cadastrar nova criança
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

        $this->responsavel_id = !empty($this->responsavel_id) ? (int)$this->responsavel_id : null;
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->data_nasc = !empty($this->data_nasc) ? $this->data_nasc : null;
        $this->data_inicio = !empty($this->data_inicio) ? $this->data_inicio : null;
        $this->data_termino = !empty($this->data_termino) ? $this->data_termino : null;
        $this->alergias = htmlspecialchars(strip_tags($this->alergias ?? ''));
        $this->restricoes_alimentares = htmlspecialchars(strip_tags($this->restricoes_alimentares ?? ''));
        $this->observacoes_gerais = htmlspecialchars(strip_tags($this->observacoes_gerais ?? ''));

        $stmt->bindParam(":responsavel_id", $this->responsavel_id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":data_nasc", $this->data_nasc);
        $stmt->bindParam(":data_inicio", $this->data_inicio);
        $stmt->bindParam(":data_termino", $this->data_termino);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":restricoes_alimentares", $this->restricoes_alimentares);
        $stmt->bindParam(":observacoes_gerais", $this->observacoes_gerais);

        return $stmt->execute();
    }

    // Atualizar criança existente
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET responsavel_id = :responsavel_id, 
                      nome = :nome, 
                      data_nasc = :data_nasc, 
                      data_inicio = :data_inicio, 
                      data_termino = :data_termino, 
                      alergias = :alergias, 
                      restricoes_alimentares = :restricoes_alimentares, 
                      observacoes_gerais = :observacoes_gerais
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = (int)$this->id;
        $this->responsavel_id = !empty($this->responsavel_id) ? (int)$this->responsavel_id : null;
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->data_nasc = !empty($this->data_nasc) ? $this->data_nasc : null;
        $this->data_inicio = !empty($this->data_inicio) ? $this->data_inicio : null;
        $this->data_termino = !empty($this->data_termino) ? $this->data_termino : null;
        $this->alergias = htmlspecialchars(strip_tags($this->alergias ?? ''));
        $this->restricoes_alimentares = htmlspecialchars(strip_tags($this->restricoes_alimentares ?? ''));
        $this->observacoes_gerais = htmlspecialchars(strip_tags($this->observacoes_gerais ?? ''));

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":responsavel_id", $this->responsavel_id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":data_nasc", $this->data_nasc);
        $stmt->bindParam(":data_inicio", $this->data_inicio);
        $stmt->bindParam(":data_termino", $this->data_termino);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":restricoes_alimentares", $this->restricoes_alimentares);
        $stmt->bindParam(":observacoes_gerais", $this->observacoes_gerais);

        return $stmt->execute();
    }

    // Excluir criança
    public function deletar($id)
    {
        // Limpar tarefas associadas à criança ou desvinculá-las
        $stmtTarefas = $this->conn->prepare("UPDATE tarefas SET crianca_id = NULL WHERE crianca_id = :id");
        $stmtTarefas->bindParam(":id", $id, PDO::PARAM_INT);
        $stmtTarefas->execute();

        // Limpar pagamentos associados ou desvinculá-los
        $stmtPags = $this->conn->prepare("UPDATE pagamentos SET crianca_id = NULL WHERE crianca_id = :id");
        $stmtPags->bindParam(":id", $id, PDO::PARAM_INT);
        $stmtPags->execute();

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Calcular idade legível a partir da data de nascimento
    public static function calcularIdade($data_nasc)
    {
        if (empty($data_nasc)) return 'Idade não informada';
        try {
            $nasc = new DateTime($data_nasc);
            $hoje = new DateTime();
            $intervalo = $hoje->diff($nasc);
            
            if ($intervalo->y > 0) {
                return $intervalo->y . ($intervalo->y == 1 ? ' ano' : ' anos');
            } elseif ($intervalo->m > 0) {
                return $intervalo->m . ($intervalo->m == 1 ? ' mês' : ' meses');
            } else {
                return $intervalo->d . ($intervalo->d == 1 ? ' dia' : ' dias');
            }
        } catch (Exception $e) {
            return '';
        }
    }
}
