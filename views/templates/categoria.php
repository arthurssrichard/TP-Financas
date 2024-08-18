<?php 
        require_once('../partials/header.php'); 
        require_once(__DIR__ . '/../../config.php');
        require_once(APP_PATH."/controllers/categoriaController.php");
        require_once(APP_PATH."/controllers/transacaoController.php");
        require_once(APP_PATH."/models/CategoriaModel.php");
        require_once(APP_PATH."/models/TransacaoModel.php");



        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $categoriaModel = new CategoriaModel($mysqli);
            $transacaoModel = new TransacaoModel($mysqli);

            $categoria = $categoriaModel->loadSingle($id);

            $nome = $categoria->getNome();
        }
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria <?=$nome?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .container{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .fa-xmark{
        position: absolute;
        top: 5%;
        left: 95%;
        transform: scale(150%);
    }
    .fa-solid:hover{
        color: var(--texto);
    }

    .fa-trash-can{
        transform: scale(180%);
        transition: 0.1s ease;
        color: #5E5E5E;
    }
    .fa-trash-can:hover{
        color: red;
    }   

    .fa-plus{
        transform: scale(180%);
    }
    
</style>

<body>
    <main>
        <div class="container">
            <h1>Categoria <?=$nome?></h1>
        </div>
        
        <div class="container-row" style="width: 80%">
            
            <section class="grafico container-column" style="gap: 20px; align-items: end;">
                <canvas id="myChart"></canvas>
                <div class="container-row" style="gap: 20px;">
                    <a href="adicionarTransacao.php?id=<?=$id?>" title="Nova Transação"><i class="fa-solid fa-plus"></i></a> 
                    <a href="#" style='margin-right: 20px;' class="abrir" onclick="abrirModal()" title="Apagar categoria"><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </section>
            <?= listarTransacoes($transacaoModel, $id);?>

        </div>

        

        <form id="postForm" action="../../controllers/categoriaController.php?action=deletar" method="post" style="display: none;">
            <input type="hidden" name="id" value="<?=$id?>">
        </form>

        <dialog class="modal" id="modal">
            <h2>Tem certeza que quer deletar essa categoria?</h2>
            <p>Não tem volta. Esta categoria e todas suas transações serão apagadas</p>
            <button onclick="postData()">Apagar categoria</button>
            <a href="#" onclick="fecharModal()"><i class="fa-solid fa-xmark"></i></a>
        </dialog>
    </main>
    <?php include '../partials/footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function postData() {
            document.getElementById('postForm').submit();
        }

        const modal = document.querySelector('#modal');
        const abrir = document.querySelector('.abrir');

        function abrirModal(){
            modal.showModal();
        }
        function fecharModal(){
            modal.close();
        }


        document.addEventListener('DOMContentLoaded', function() {
            fetch("../../functions/getDados.php/?action=default&from=<?=$id?>")
                .then(response => response.json())
                .then(data => {
                    // Supondo que a resposta seja um array de objetos com 'valor' e 'descricao'
                    const labels = data.map(item => item.data);
                    const valores = data.map(item => item.valor);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'line', // ou 'line', 'pie', etc.
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Valores das Transações',
                                data: valores,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'red',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao buscar os dados:', error));
        });
    </script>
</body>
</html>