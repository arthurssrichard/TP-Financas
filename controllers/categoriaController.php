<?php 
require_once(__DIR__ . '/../config.php');
require_once(APP_PATH.'/models/class_Categoria.php');
require_once(APP_PATH.'/models/CategoriaModel.php');


$categoriaModel = new CategoriaModel($mysqli);

function salvarCategoria($categoriaModel){
    echo"Adicionando categoria...2 <br>";
    if(isset($_POST['nome']) && isset($_POST['cor'])){
        $nome = $categoriaModel->getConn()->real_escape_string($_POST['nome']);
        $cor = $categoriaModel->getConn()->real_escape_string($_POST['cor']);
        $cor = preg_replace('/^./', '', $cor); //remove o # da cor
        // criar modelo/objeto categoria
    $categoria = new Categoria($nome, $cor);

    $categoriaModel->save($categoria);
    header('Location: ../views/templates/categorias.php');
    }
}

function deletarCategoria($categoriaModel){
    echo"Deletando categoria...";
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $categoriaModel->delete($id);
    }
    header('Location: ../views/templates/categorias.php');
}

function listarCategorias($categoriaModel){
    $categorias = $categoriaModel->loadAll();
    foreach ($categorias as $categoria) {
        $id = $categoria->getID();
        $nome = $categoria->getNome();
        $cor = $categoria->getCor();
        $cor2 = escurecerCorHex($cor,15);
        $background =  'style="background-image: linear-gradient(to left, #'.$cor.', '.$cor2.')"';
        echo"<a href='../templates/categoria.php?id=".$id."'><div class='categoria' $background><span class='categoria-text'>$nome</span></div></a>";
    }
}




function escurecerCorHex($hex, $percentual) {
    // Remove o símbolo '#' se presente
    $hex = str_replace('#', '', $hex);

    // Converte hexadecimal para RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Calcula a quantidade para escurecer
    $escurecer = function($valor, $percentual) {
        return max(0, min(255, $valor - ($valor * $percentual / 100)));
    };

    // Aplica o escurecimento
    $r = $escurecer($r, $percentual);
    $g = $escurecer($g, $percentual);
    $b = $escurecer($b, $percentual);

    // Converte RGB de volta para hexadecimal
    $novoHex = sprintf("#%02x%02x%02x", $r, $g, $b);

    return $novoHex;
}

function transacoes($idCategoria){
    
}

if(isset($_GET['action']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_GET['action'];
    if($action == 'adicionar'){
        salvarCategoria($categoriaModel);
    }else if($action == 'deletar'){
        deletarCategoria($categoriaModel);
    }
}