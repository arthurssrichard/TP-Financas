<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/class_Categoria.php');
class CategoriaModel{
    private $conn;
    public function getConn(){
        return $this->conn;
    }
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function save(Categoria $categoria){
        $nome = $categoria->getNome(); $cor = $categoria->getCor();
        $sql_code = "INSERT INTO categorias (nome, cor) VALUES ('$nome', '$cor')";
        $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);
    }

    public function delete(int $id){
        $sql_code = "DELETE FROM categorias WHERE id = $id";
        $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);
    }

    public function loadAll(): array{
        $sql_code = "SELECT id, nome, cor FROM categorias";
        $sql_query = $this->conn->query($sql_code) or die("Falha ao executar SQL: " . $this->conn->error);

        $categorias = [];
        while ($row = $sql_query->fetch_assoc()) {
            $categoria = new Categoria($row['nome'], $row['cor']);
            $categoria->setID($row['id']);
            $categorias[] = $categoria;
        }
        return $categorias; 
    }

    public function loadSingle($id) {
        // Sanitizar o ID para evitar SQL injection
        $id = $this->conn->real_escape_string($id);
    
        $sql_code = "SELECT * FROM categorias WHERE id = $id LIMIT 1";
        $sql_query = $this->conn->query($sql_code) or die('Falha ao executar SQL: ' . $this->conn->error);
    
        if ($row = $sql_query->fetch_assoc()) {
            $categoria = new Categoria($row['nome'], $row['cor']);
            $categoria->setID($row['id']);
            return $categoria;
        } else {
            return null; // Retorna null se a categoria não for encontrada
        }
    }

    public function transactions($id){
        $id = $this->conn->real_escape_string($id);
        $sql_code = "SELECT * FROM transacoes WHERE id_categoria = $id";
        $sql_query = $this->conn->query($sql_code) or die('Falha ao executar SQL: ' . $this->conn->error);

        if ($row = $sql_query->fetch_assoc()) {
            $categoria = new Categoria($row['nome'], $row['cor']);
            $categoria->setID($row['id']);
            return $categoria;
        } else {
            return null; // Retorna null se a categoria não for encontrada
        }
    }
    
}