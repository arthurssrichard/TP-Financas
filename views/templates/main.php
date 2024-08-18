<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<style>
    .container-row{
        padding: 0;
        width: 100%;
        justify-content: center;
        vertical-align: middle;
    }
    section{
        padding: 20px;
    }
    .media{
        height: 300px;
    }
    #media{
        font-size: 100px;
    }
    #column2{
        width: 30%;
        border-left: 1px solid rgb(230, 230, 230);
        padding: 10px 0px 20px 20px;
    }
    .button-active{
        background-color: var(--texto);
        color: var(--base);
    }

</style>
<body>
    <?php require_once('../partials/header.php');
    require_once('../../functions/getDados.php');
    ?>
    <main>
        <h1>Visão Geral</h1>
            <section class="grafico" style="width: 1000px;">
                <div style="width: 68%;">
    	            <canvas id="grafico1"></canvas>
                    <div class="botton-menu">
                        <button data-periodo="1s">Última semana</button>
                        <button data-periodo="1m">Último mês</button>
                        <button data-periodo="3m">Últimos 3 meses</button>
                        <button data-periodo="1a">Último ano</button>
                    </div>
                </div>

                <div id="column2">
                    <h2>Media diaria gasta:</h2>
                    <p>R$ <span id="media">Err</span></p>

                </div>
            </section>
    </main>    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart1; // Variável para armazenar o gráfico

    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa o gráfico com o período padrão (por exemplo, última semana)
        grafico1('3m');
        
        // Adiciona evento de clique aos botões
        document.querySelectorAll('.botton-menu button').forEach(button => {
            button.addEventListener('click', function() {
                const periodo = this.getAttribute('data-periodo');
                
                // Remover a classe ativa de todos os botões
                document.querySelectorAll('.botton-menu button').forEach(btn => {
                    btn.classList.remove('button-active');
                });

                // Adicionar a classe ativa ao botão clicado
                this.classList.add('button-active');

                // Chama a função grafico1 com o período selecionado
                grafico1(periodo);
            });
        });
    });

    function grafico1(periodo) {
    fetch(`../../functions/getDados.php/?action=dinTotalDiarioMovimentado&periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            const valor = data.transacoes.map(item => item.valor_diario);
            const labels = data.transacoes.map(item => item.dia);
            const mediaGlobal = parseFloat(data.media_global);

            const ctx = document.getElementById('grafico1').getContext('2d');

            // Se já existe um gráfico, destrua-o antes de criar um novo
            if (chart1) {
                chart1.destroy();
            }

            // Cria um novo gráfico
            chart1 = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `Dinheiro gasto no dia (Média diária: ${mediaGlobal.toFixed(2)})`,
                        data: valor,
                        backgroundColor: 'white',
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
            media = mediaGlobal.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('media').innerText = media;
        })
        .catch(error => console.error('Erro ao buscar os dados:', error));

}

    function mediaDiaria(periodo){

    }
</script>



    <?php require_once('../partials/footer.php')?>
</body>
</html>

