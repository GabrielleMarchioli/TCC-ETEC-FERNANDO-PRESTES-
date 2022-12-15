<?php
include_once('Vadm.php');

date_default_timezone_set('America/Sao_Paulo');

function insertRelatorio($conexao, $categoria, $faixaEtaria, $cor, $tipo, $tamanho, $data) {
    $sqlRelatorio = "INSERT INTO `relatorio` (`categoria`, `faixaEtaria`, `cor`, `tipo`, `tamanho`, `data_relatorio`) VALUES ('$categoria', '$faixaEtaria', '$cor', '$tipo', '$tamanho', '$data')";
    $resultadoRelatorio = mysqli_query($conexao, $sqlRelatorio);

    if($resultadoRelatorio) return "<script>window.location='relatorioPC.php'</script>";
    else return '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br><b>Query Inválida:</b>' . @mysqli_error($conexao);
}

if(array_key_exists('categoria', $_POST) && array_key_exists('faixaEtaria', $_POST) && array_key_exists('cor', $_POST) && array_key_exists('tipo', $_POST) && array_key_exists('tamanho', $_POST) ) {
    echo insertRelatorio($conexao, $_POST["categoria"], $_POST["faixaEtaria"], $_POST["cor"], $_POST["tipo"], $_POST["tamanho"], date("Y-m-d H:i:s"));
}
?>

<script>window.location='relatorioPC.php'</script>
