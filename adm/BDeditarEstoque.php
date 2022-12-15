<?php
include_once("Vadm.php");

date_default_timezone_set('America/Sao_Paulo');

function adicionarEstoque($conexao, $idProduto, $quantidadeEstoque, $observacao) {
    $sqlIdProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$idProduto'";
    $resultadoIdProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlIdProduto));
    $idProdutoR = $resultadoIdProduto["idProduto"];
    $data = date("Y-m-d H:i:s");
    
    $sqlEstoque = "UPDATE `Produto` SET `quantidadeEstoque` = (`quantidadeEstoque` + $quantidadeEstoque) WHERE md5(`idProduto`) = '$idProduto'";
    $sqlMovimento = "INSERT INTO `Movimento` (`tipo`, `data`, `quantidade`, `observacao`, `idProduto`) VALUES (1, '$data', $quantidadeEstoque, '$observacao', $idProdutoR)";
    $resultadoEstoque = mysqli_query($conexao, $sqlEstoque);
    $resultadoMovimento = mysqli_query($conexao, $sqlMovimento);

    if($resultadoEstoque && $resultadoMovimento) return "<script>window.location='editarEstoque.php?id=$idProduto'</script>";
    else return "<script>window.location='editarEstoque.php?id=$idProduto&erro=5'</script>";
}

function removerEstoque($conexao, $idProduto, $quantidadeEstoque, $observacao) {
    $sqlIdProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$idProduto'";
    $resultadoIdProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlIdProduto));
    $idProdutoR = $resultadoIdProduto["idProduto"];
    $data = date("Y-m-d H:i:s");
    
    $sqlEstoque = "UPDATE `Produto` SET `quantidadeEstoque` = (`quantidadeEstoque` - $quantidadeEstoque) WHERE md5(`idProduto`) = '$idProduto'";
    $sqlMovimento = "INSERT INTO `Movimento` (`tipo`, `data`, `quantidade`, `observacao`, `idProduto`) VALUES (0, '$data', $quantidadeEstoque, '$observacao', $idProdutoR)";
    $resultadoEstoque = mysqli_query($conexao, $sqlEstoque);
    $resultadoMovimento = mysqli_query($conexao, $sqlMovimento);

    if($resultadoEstoque && $resultadoMovimento) return "<script>window.location='editarEstoque.php?id=$idProduto'</script>";
    else return "<script>window.location='editarEstoque.php?id=$idProduto&erro=6'</script>";
}

if(array_key_exists("op", $_POST) && array_key_exists("id", $_POST) && array_key_exists("quantidadeEstoque", $_POST) && array_key_exists("observacao", $_POST)) {
    $id = $_POST["id"];
    $op = $_POST["op"];
    $quantidadeEstoque = $_POST["quantidadeEstoque"];
    $observacao = $_POST["observacao"];
    
    if($op == 0) echo removerEstoque($conexao, $id, $quantidadeEstoque, $observacao);
    else echo adicionarEstoque($conexao, $id, $quantidadeEstoque, $observacao);
}

if(array_key_exists("id", $_POST)) echo "<script>window.location='editarEstoque.php?id=" . $_GET["id"] . "&erro=4'</script>";
else echo "<script>window.location='inicio.php'</script>";
?>