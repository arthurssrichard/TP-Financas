<?php 
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/class_Transacao.php');
class TransacaoModel{
    private $conn;

    public function __construct($conn){$this->conn = $conn;}
    public function getConn(){return $this->conn;}

    public function save(Transacao $transacao){
        $id_categoria = $transacao->getIdCategoria();
        $valor = $transacao->getValor();
        $descricao = $transacao->getDescricao();
        $data = $transacao->getData();

        $sql_code = "INSERT INTO transacoes (id_categoria, valor, descricao, data) VALUES ('$id_categoria','$valor','$descricao','$data')";
        $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);
    }

    public function loadFromCategory($id_categoria): array{
        $sql_code = "SELECT * FROM transacoes WHERE id_categoria = $id_categoria";
        $sql_query = $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);
        $transacoes = [];
        while($row = $sql_query->fetch_assoc()){
            $transacao = new Transacao($row['id_categoria'], $row['valor'], $row['descricao'], $row['data']);
            $transacao->setId($row['id']);
            $transacoes[] = $transacao;
        }
        return $transacoes;
    }
    public function loadAll(){
        $sql_code = "SELECT t.id AS transacao_id, c.id AS categoria_id, c.nome, t.valor, t.descricao, t.data FROM transacoes as t
                    JOIN categorias AS c ON t.id_categoria = c.id ORDER BY t.data DESC;";
        $sql_query = $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);
        $transacoes = [];
        while($row = $sql_query->fetch_assoc()){
            $transacoes[] = $row;
        }
        return $transacoes;
    }
}