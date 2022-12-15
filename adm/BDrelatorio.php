<?php
include_once("Vadm.php");

date_default_timezone_set('America/Sao_Paulo');

function inserirRelatorio($conexao, $categoria, $faixaEtaria, $cor, $tipo, $tamanho, $data) {
    $sqlRelatorio = "INSERT INTO `relatorio` (`categoria`, `faixaEtaria`, `cor`, `tipo`, `tamanho`, `data_relatorio`) VALUES ('$categoria', '$faixaEtaria', '$cor', '$tipo', '$tamanho', '$data')";
    $resultadoRelatorio = mysqli_query($conexao, $sqlRelatorio);

    if($resultadoRelatorio) return "<script>window.location='painelControle.php?aba=relatorio'</script>";
    else return "<script>window.location='painelControle.php?aba=relatorio&erro=1'</script>";
}

function excluirRelatorio($conexao, $idRelatorio) {
    $sqlRelatorio = "DELETE FROM `relatorio` WHERE `idRelatorio` = '$idRelatorio'";
    $resultadoRelatorio = mysqli_query($conexao, $sqlRelatorio);

    if($resultadoRelatorio) return "<script>window.location='painelControle.php?aba=relatorio'</script>";
    else return "<script>window.location='painelControle.php?aba=relatorio&erro=2'</script>";
}

if(array_key_exists("acao", $_POST)) {
    if($_POST["acao"] == 0) {
        if(array_key_exists('idRelatorio', $_POST)) {
            echo excluirRelatorio($conexao, $_POST["idRelatorio"]);
        }
        else return "<script>window.location='painelControle.php?aba=relatorio&erro=3'</script>";
    }
    else if($_POST["acao"] == 1) {
        if(array_key_exists('categoria', $_POST) && array_key_exists('faixaEtaria', $_POST) && array_key_exists('cor', $_POST) && array_key_exists('tipo', $_POST) && array_key_exists('tamanho', $_POST) ) {
            echo inserirRelatorio($conexao, $_POST["categoria"], $_POST["faixaEtaria"], $_POST["cor"], $_POST["tipo"], $_POST["tamanho"], date("Y-m-d H:i:s"));
        }
        else return "<script>window.location='painelControle.php?aba=relatorio&erro=4'</script>";
    }
}
?>

<script>
    window.location='painelControle.php?aba=relatorio';
</script>