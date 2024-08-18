<?php 
require_once(__DIR__ . '/../config.php');
require_once(APP_PATH.'/models/class_Transacao.php');
require_once(APP_PATH.'/models/TransacaoModel.php');

$transacaoModel = new TransacaoModel($mysqli);

function salvarTransacao($transacaoModel){
    echo"Adicionando transacao...2 <br>";
    if(isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['data']) && isset($_POST['id-categoria']));

    $valor = $transacaoModel->getConn()->real_escape_string($_POST['valor']);
    $descricao = $transacaoModel->getConn()->real_escape_string($_POST['descricao']);
    $data = $transacaoModel->getConn()->real_escape_string($_POST['data']);
    $idCategoria = $transacaoModel->getConn()->real_escape_string($_POST['id-categoria']);

    $transacao = new Transacao($idCategoria, $valor, $descricao, $data);
    $transacaoModel->save($transacao);
    header('Location: ../index.php');
}

function deletarTransacao($transacaoModel){

}

function listarTransacoes($transacaoModel, $idCategoria){
    $transacoes = $transacaoModel->loadFromCategory($idCategoria);
    require_once(APP_PATH."/views/partials/tabelaTransacoes.php");
}
function listarTodasTransacoes($transacaoModel){
    $transacoes = $transacaoModel->loadAll();
    require_once(APP_PATH."/views/partials/tabelaTodasTransacoes.php");
}
function limitarDescricao(String $descricao, int $limite = 5) {
    $palavras = explode(' ', $descricao);

    if (count($palavras) > $limite) {
        $palavras = array_slice($palavras, 0, $limite);

        $descricaoNova = implode(' ', $palavras) . '...';
    } else {
        $descricaoNova = $descricao;
    }

    return $descricaoNova;
}




if(isset($_GET['action']) && $_SERVER['REQUEST_METHOD']==='POST'){
    $action = $_GET['action'];
    if($action == 'adicionar'){
        salvarTransacao($transacaoModel);
    }else if($action == 'deletar'){
        deletarTransacao($transacaoModel);
    }
}