<?php
require_once(__DIR__ . '/../config.php');
class Categoria{
    private int $id;
    private String $nome;
    private String $cor;


    public function __construct(String $nome, String $cor) {
        $this->nome = $nome;
        $this->cor = $cor;
    }

    public function getNome(): String{return $this->nome;}
    public function getCor(): String{return $this->cor;}
    public function setNome($nome): void{$this->nome= $nome;}
    public function setCor($cor): void{$this->cor= $cor;}
    public function setID(int $id): void{$this-> id = $id;}
    public function getID(): int{return $this->id;}
}
