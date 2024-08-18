<?php require_once(__DIR__ . '/../../config.php');?>


<table>
    <thead>
        <tr>
            <th>ID</th> <th>Valor</th> <th>Descrição</th> <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($transacoes as $transacao){
            $valor = $transacao->getValor();
            $valor = number_format($valor, 2, ",", ".");
            $id = $transacao->getId();
            $data = $transacao->getData();
            $descricao = $transacao->getDescricao();
            $descricaoNova = limitarDescricao($descricao);


            echo"<tr>
            <td>$id</td> <td><span style='font-size: 10px;'>R$</span> $valor</td> <td title='".$descricao."'>$descricaoNova</td> <td>$data</td>
            </tr>";
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>