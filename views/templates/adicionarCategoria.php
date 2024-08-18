<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<?php 
require_once('../partials/header.php'); 
require_once(__DIR__ . '/../../config.php');
require_once(APP_PATH."/controllers/categoriaController.php");
?>
<body>
    <main>
        <h1>Adicionar Categoria</h1>
        <section class="container-row form-section">
            <form action="../../controllers/categoriaController.php?action=adicionar" method="post">
                <label for="nome">Nome</label>
                <input name="nome" type="text" required>
                <label for="cor">Cor</label>
                <input name="cor" type="color" required>

                <input type="submit" value="Adicionar">
            </form>
        </section>
    </main>
    <?php require_once '../partials/footer.php'?>
</body>
</html>