<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transações</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php require_once('../partials/header.php'); 
require_once(__DIR__ . '/../../config.php');
require_once('../../models/TransacaoModel.php');
require_once('../../controllers/transacaoController.php');
?>
<?php 
$transacaoModel = new TransacaoModel($mysqli);
?>
<main>
    <h1>Transações</h1>
    <?= listarTodasTransacoes($transacaoModel);?>
</main>
<?php require_once('../partials/footer.php')?>
</body>
</html>