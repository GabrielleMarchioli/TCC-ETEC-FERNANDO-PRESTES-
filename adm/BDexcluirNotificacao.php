<?php

include_once('Vadm.php');
            
include_once('../conexao.php');
$idNotificacao = $_GET['idNotificacao'];

$sqldelete =  "DELETE FROM `Notificacao` WHERE md5(`idNotificacao`) = '$idNotificacao'";

// executando instrução SQL
$resultado = @mysqli_query($conexao, $sqldelete);
if (!$resultado) {
    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
} else {
    echo "<script>window.location='painelControle.php?notificacao=1'</script>";
} 
mysqli_close($conexao);

?>
