<?php

include_once('Vadm.php');       
include_once('../conexao.php');

date_default_timezone_set('America/Sao_Paulo');

$texto = $_POST["texto"];

function insertNotificacao($conexao, $texto) {
    $sqlNotificacao = "INSERT INTO `Notificacao` (`textoNotificacao`, `dataNotificacao`) VALUES ('$texto', '" . date("Y-m-d H:i:s") . "')";

    if(mysqli_query($conexao, $sqlNotificacao)) return "<script>window.location='painelControle.php?notificacao=1'</script>";
    else return '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br><b>Query Inválida:</b>' . @mysqli_error($conexao);
}

if(array_key_exists('novaNotificacao', $_POST)) {
    echo insertNotificacao($conexao, $texto);
}
?>
