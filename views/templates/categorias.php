<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<?php 
require_once('../partials/header.php'); 
require_once(__DIR__ . '/../../config.php');

?>
<body>

    <main>
        <h1>Categorias</h1>
    <div class="container-row">

        
        <section class="container-row">
            <div class="lateral-menu">
                <button type="button" onclick="toggleGrafico2()" id="botao2">Dinheiro movimentado</button>
                <button type="button" onclick="toggleGrafico1()" id="botao1">Nº de inserções</button>
            </div>
            <div >
            <canvas id="grafico1"></canvas>
            <canvas id="grafico2"></canvas>
            </div>
        </section>

        <section>
            <div class="categorias">
                <?php require_once(APP_PATH.'/controllers/categoriaController.php');
                $categoriaModel = new CategoriaModel($mysqli);
                listarCategorias($categoriaModel);
                ?>
            </div>
        </section>
    </div>

        <section class="container-row">
            <h2>Precisando de categoria? <a href="adicionarCategoria.php">Adicione uma!</a></h2>
        </section>
    </main>
    <?php include '../partials/footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            grafico1();
            grafico2();
            document.getElementById('botao2').classList.add('active');
            toggleGrafico2();
        });
        const graf1 = document.getElementById('grafico1');
        const graf2 = document.getElementById('grafico2');

        function toggleGrafico1(){
            if(graf1.style.display == "none"){
                graf1.style.display = "block";
                setActiveButton('botao1');
            }
            graf2.style.display = "none";
        }
        function toggleGrafico2(){
            if(graf2.style.display == "none"){
                graf2.style.display = "block";
                setActiveButton('botao2');

            }
            graf1.style.display = "none";
        }

        function grafico1(){
                fetch("../../functions/getDados.php/?action=categNum")
                    .then(response => response.json())
                    .then(data => {
                        // Supondo que a resposta seja um array de objetos com 'valor' e 'descricao'
                        const labels = data.map(item => item.nome);
                        const quant = data.map(item => item['count(t.id_categoria)']);
                        const cores = data.map(item => '#'+item.cor);
        
                        const ctx = document.getElementById('grafico1').getContext('2d');
                        const chart1 = new Chart(ctx, {
                            type: 'doughnut', // ou 'line', 'pie', etc.
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Quantidade de Transações',
                                    data: quant,
                                    backgroundColor: cores,
                                    borderColor: 'red',
                                    borderWidth: 0
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
            }

            function grafico2(){
                fetch("../../functions/getDados.php/?action=dinMovimentado")
                    .then(response => response.json())
                    .then(data => {
                        // Supondo que a resposta seja um array de objetos com 'valor' e 'descricao'
                        const labels = data.map(item => item.nome);
                        const valorTotal = data.map(item => item['sum(t.valor)']);
                        const cores = data.map(item => '#'+item.cor);
        
                        const ctx = document.getElementById('grafico2').getContext('2d');
                        const chart2 = new Chart(ctx, {
                            type: 'doughnut', // ou 'line', 'pie', etc.
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Dinheiro total gasto',
                                    data: valorTotal,
                                    backgroundColor: cores,
                                    borderColor: 'red',
                                    borderWidth: 0
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
            }

            function setActiveButton(buttonId) {
                // Remover a classe 'active' de todos os botões
                document.querySelectorAll('button').forEach(button => {
                    button.classList.remove('active');
                });

                // Adicionar a classe 'active' ao botão clicado
                document.getElementById(buttonId).classList.add('active');
            }
</script>
</body>
</html>
