<?php 
require_once(__DIR__ . '/../config.php');
class Transacao{
    private int $id;
    private int $id_categoria;
    private float $valor;
    private String $descricao;
    private String $data;

    public function __construct(int $id_categoria, float $valor, String $descricao, String $data){
        $this->id_categoria = $id_categoria;
        $this->valor = $valor;
        $this->descricao = $descricao;
        $this->data = $data;
    }

    public function getData(): String {return $this->data;}
    public function getId(): int { return $this->id; }
    public function getIdCategoria(): int { return $this->id_categoria; }
    public function getValor(): float { return $this->valor; }
    public function getDescricao(): String { return $this->descricao; }
    
    public function setData(String $data): void{$this->data = $data;}
    public function setId(int $id): void{$this->id = $id;}
    public function setIdCategoria(int $id_categoria): void { $this->id_categoria = $id_categoria; }
    public function setValor(float $valor): void { $this->valor = $valor; }
    public function setDescricao(String $descricao): void { $this->descricao = $descricao; }
}