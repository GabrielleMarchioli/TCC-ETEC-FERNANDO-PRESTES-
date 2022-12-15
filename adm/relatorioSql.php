<?php
$sqlRelatorio =
"SELECT (
    SELECT categoria FROM
    (SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
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
    WHERE e.status > 0 AND e.status != 3) testeproduto
    group by categoria
    order by count(categoria) desc
    limit 1
) as categoria,
(
    SELECT faixaEtaria FROM
    (SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
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
    WHERE e.status > 0 AND e.status != 3) testeproduto
    group by faixaEtaria
    order by count(faixaEtaria) desc
    limit 1
) as faixaEtaria,
(
    SELECT cor FROM
    (SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
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
    WHERE e.status > 0 AND e.status != 3) testeproduto
    group by cor
    order by count(cor) desc
    limit 1
) as cor,
(
    SELECT tipo FROM
    (SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
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
    WHERE e.status > 0 AND e.status != 3) testeproduto
    group by tipo
    order by count(tipo) desc
    limit 1
) as tipo,
(
    SELECT tamanho FROM
    (SELECT a.nome as 'categoria', p.faixaEtaria, c.corNome as 'cor', t.tipoNome as 'tipo', p.tamanho FROM Produto p
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
    WHERE e.status > 0 AND e.status != 3) testeproduto
    group by tamanho
    order by count(tamanho) desc
    limit 1
) as tamanho;";
?>