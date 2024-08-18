<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/conexao.php';



function transacoesCategoria($mysqli, $category){
    $query = "SELECT * FROM transacoes WHERE id_categoria = $category";
    $result = $mysqli->query($query);
    
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
}

function categoriasNumeroInsercoes($mysqli){
    $query = "SELECT c.nome, c.cor, count(t.id_categoria) FROM transacoes as t
              JOIN categorias as c ON t.id_categoria = c.id
              GROUP BY t.id_categoria;";
    $result = $mysqli->query($query);
    
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
}

function dinMovimentado($mysqli){
    $query = "SELECT c.nome, c.cor, sum(t.valor) FROM transacoes as t
            JOIN categorias as c ON t.id_categoria = c.id
            GROUP BY t.id_categoria;";
    $result = $mysqli->query($query);
    
    $data = array();
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
}



function dinTotalDiarioMovimentado($mysqli, $interval) {
    $query = "SELECT SUM(valor) AS valor_diario, `data` AS dia
              FROM transacoes
              WHERE `data` >= DATE_SUB(CURDATE(), INTERVAL $interval)
              GROUP BY `data`;";
    
    $result = $mysqli->query($query);
    $transacoes = [];

    while ($row = $result->fetch_assoc()) {
        $transacoes[] = $row;
    }

    // Calcular a média global
    $media = mediaDinDiaria($mysqli, $interval);

    // Combinar as transações e a média em um único array
    $response = [
        "transacoes" => $transacoes,
        "media_global" => $media
    ];

    echo json_encode($response);
}

function mediaDinDiaria($mysqli, $interval) {
    // Ajustar a subtração da data inicial
    $query = "WITH RECURSIVE all_dates AS (
                  SELECT CURDATE() - INTERVAL $interval + INTERVAL 1 DAY AS `date`
                  UNION ALL
                  SELECT `date` + INTERVAL 1 DAY
                  FROM all_dates
                  WHERE `date` + INTERVAL 1 DAY <= CURDATE()
              )
              SELECT AVG(IFNULL(t.valor, 0)) AS media_global
              FROM all_dates ad
              LEFT JOIN transacoes t ON ad.`date` = t.`data`;";
    
    $result = $mysqli->query($query);
    $media = 0;

    if ($row = $result->fetch_assoc()) {
        $media = $row['media_global'];
    }

    return $media;
}



//echo date("Y-m-d");
/*
1 WEEK
1 MONTH
3 MONTH
1 YEAR
*/

if(isset($_GET['action'])){
    $action = $_GET['action'];
    $category = $_GET['from']??null;

    if($action === 'default'){
        transacoesCategoria($mysqli, $category);

    }else if ($action === 'categNum'){
        categoriasNumeroInsercoes($mysqli);

    }else if ($action === 'dinMovimentado'){
        dinMovimentado($mysqli);
    }else if ($action === 'dinTotalDiarioMovimentado' && isset($_GET['periodo'])){
        switch($_GET['periodo']){
            case "1s":
                dinTotalDiarioMovimentado($mysqli, '1 WEEK');
                break;

            case "1m":
                dinTotalDiarioMovimentado($mysqli, '1 MONTH');
                break;

            case "3m":
                dinTotalDiarioMovimentado($mysqli, '3 MONTH');
                break;

            case "1a":
                dinTotalDiarioMovimentado($mysqli, '1 YEAR');
                break;
        }
    }
}

?>
