<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova transação</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php 
require_once('../partials/header.php'); 
require_once(__DIR__ . '/../../config.php');
require_once(APP_PATH."/controllers/categoriaController.php");

if(isset($_GET)){
    $id = $_GET['id'];
}
?>
<body>
    <main>
        <h1>Adicionar Transação</h1>
        <section class="container-row form-section">
        <form action="../../controllers/transacaoController.php?action=adicionar" method="post">

                <label for="valor">Valor</label>
                <input name="valor" type="text" required>

                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" required></textarea>

                <label for="data">Data</label>
                <input type="date" name="data">

                <input type="hidden" name="id-categoria" value="<?=$id?>">
                <input type="submit" value="Adicionar">
            </form>
        </section>
    </main>
    <?php require_once '../partials/footer.php'?>
</body>
</html>