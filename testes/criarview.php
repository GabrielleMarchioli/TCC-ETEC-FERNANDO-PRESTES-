<?php

include_once('../conexao.php');

$sqlupdate =  "CREATE VIEW Testando AS
SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
INNER JOIN Categoria a
ON p.idCategoria = a.idCategoria
INNER JOIN Cor c
ON p.idCor = c.idCor
INNER JOIN Tipo t
ON p.idTipo = t.idTipo
INNER JOIN ItemPedido i
ON p.idProduto = i.idProduto
INNER JOIN Pedido e
ON i.idPedidoFk = e.idPedido
WHERE e.status > 0 AND e.status != 3;";

$resultado = mysqli_query($conexao, $sqlupdate);
if (!$resultado) {
echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' /*. @mysqli_error($conexao)*/); 
} else {

    echo 'Auto increment alterado com sucesso';
}

mysqli_close($conexao);

?>