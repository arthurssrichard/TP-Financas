<?php require_once(__DIR__ . '/../../config.php');?>


<table>
    <thead>
        <tr>
            <th>ID</th> <th>Categ.</th> <th>Valor</th> <th>Descrição</th> <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $transacoes;
        foreach($transacoes as $transacao){
            $transacao_id = $transacao['transacao_id'];
            $categoria_id = $transacao['categoria_id'];
            $categoria_nome = $transacao['nome'];
            $valor = $transacao['valor'];
            $data = strval($transacao['data']);
            $descricao = strval($transacao['descricao']);
            $descricaoNova = limitarDescricao($descricao, 8);

            echo"<tr>
            <td>$transacao_id</td> <td><a href='../../views/templates/categoria.php?id=".$categoria_id."'>$categoria_nome</a></td> <td><span style='font-size: 10px;'>R$</span> $valor</td> <td title='".$descricao."'>$descricaoNova</td> <td>$data</td>
            </tr>";
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>