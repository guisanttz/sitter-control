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

    // Sanitizar e converter valor de forma segura para o banco
    public static function sanitizarValor($valor)
    {
        if (is_numeric($valor)) {
            return number_format((float)$valor, 2, '.', '');
        }

        $v = trim((string)$valor);
        $v = str_replace(['R$', ' '], '', $v);

        // Se houver vírgula, trata como padrão brasileiro (vírgula decimal)
        if (strpos($v, ',') !== false) {
            $v = str_replace('.', '', $v); // Remove pontos de milhar
            $v = str_replace(',', '.', $v); // Substitui vírgula decimal por ponto
        }

        return number_format((float)$v, 2, '.', '');
    }

    // Listar todos os pagamentos com nomes de responsáveis e crianças
    public function listar()
    {
        $query = "SELECT p.*, r.nome as nome_responsavel, c.nome as nome_crianca 
                  FROM " . $this->table_name . " p
                  LEFT JOIN responsaveis r ON p.responsavel_id = r.id
                  LEFT JOIN criancas c ON p.crianca_id = c.id
                  ORDER BY p.data_vencimento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar pagamento por ID
    public function buscarPorId($id)
    {
        $query = "SELECT p.*, r.nome as nome_responsavel, c.nome as nome_crianca 
                  FROM " . $this->table_name . " p
                  LEFT JOIN responsaveis r ON p.responsavel_id = r.id
                  LEFT JOIN criancas c ON p.crianca_id = c.id
                  WHERE p.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cadastrar novo pagamento
    public function cadastrar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET responsavel_id = :responsavel_id, 
                      crianca_id = :crianca_id, 
                      valor = :valor, 
                      data_vencimento = :data_vencimento, 
                      status = :status";
        $stmt = $this->conn->prepare($query);

        $this->responsavel_id = (int)$this->responsavel_id;
        $this->crianca_id = !empty($this->crianca_id) ? (int)$this->crianca_id : null;
        $this->valor = self::sanitizarValor($this->valor);
        $this->data_vencimento = !empty($this->data_vencimento) ? $this->data_vencimento : date('Y-m-d');
        $this->status = in_array($this->status, ['Pago', 'Pendente', 'Agendado']) ? $this->status : 'Pendente';

        $stmt->bindParam(":responsavel_id", $this->responsavel_id, PDO::PARAM_INT);
        $stmt->bindParam(":crianca_id", $this->crianca_id, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":data_vencimento", $this->data_vencimento);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    // Atualizar pagamento
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET responsavel_id = :responsavel_id, 
                      crianca_id = :crianca_id, 
                      valor = :valor, 
                      data_vencimento = :data_vencimento, 
                      status = :status
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = (int)$this->id;
        $this->responsavel_id = (int)$this->responsavel_id;
        $this->crianca_id = !empty($this->crianca_id) ? (int)$this->crianca_id : null;
        $this->valor = self::sanitizarValor($this->valor);
        $this->data_vencimento = !empty($this->data_vencimento) ? $this->data_vencimento : date('Y-m-d');
        $this->status = in_array($this->status, ['Pago', 'Pendente', 'Agendado']) ? $this->status : 'Pendente';

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":responsavel_id", $this->responsavel_id, PDO::PARAM_INT);
        $stmt->bindParam(":crianca_id", $this->crianca_id, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":data_vencimento", $this->data_vencimento);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    // Deletar pagamento
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Obter totais para os cards do dashboard e de pagamentos
    public function obterTotais()
    {
        $mesAtual = date('m');
        $anoAtual = date('Y');

        $query = "SELECT 
                    COALESCE(SUM(CASE WHEN status = 'Pago' AND MONTH(data_vencimento) = :mes AND YEAR(data_vencimento) = :ano THEN valor ELSE 0 END), 0) as total_mes,
                    COALESCE(SUM(CASE WHEN status = 'Pendente' THEN valor ELSE 0 END), 0) as total_pendente,
                    COALESCE(SUM(CASE WHEN status = 'Agendado' THEN valor ELSE 0 END), 0) as total_agendado,
                    COALESCE(SUM(CASE WHEN status = 'Pago' THEN valor ELSE 0 END), 0) as total_recebido_geral
                  FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":mes", $mesAtual);
        $stmt->bindParam(":ano", $anoAtual);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
