<?php

include_once('Vadm.php');

function updateProduto($conexao, $id) {
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $idCategoria = $_POST["idCategoria"];
    $faixaEtaria = $_POST["faixaEtaria"];
    $idCor = $_POST["idCor"];
    $idTipo = $_POST["idTipo"];
    $tamanho = $_POST["tamanho"];

    $sqlProduto = "UPDATE `Produto` SET `nome` = '$nome', `descricao` = '$descricao', `preco` = '$preco', `idCategoria` = '$idCategoria', `faixaEtaria` = '$faixaEtaria', `idCor` = '$idCor', `idTipo` = '$idTipo', `tamanho` = '$tamanho' WHERE md5(`idProduto`) = '$id'";
    if(mysqli_query($conexao, $sqlProduto)) return "<script>window.location='painelControle.php?aba=produtos'</script>";
    else return '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br><b>Query Inválida:</b>' . @mysqli_error($conexao);
}

if(array_key_exists('id', $_GET)) {
    echo updateProduto($conexao, $_GET["id"]);
}
?>
