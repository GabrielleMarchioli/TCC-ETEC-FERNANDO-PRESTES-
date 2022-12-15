<?php

include_once('../conexao.php');

$sqlupdate =  "ALTER TABLE `Pedido` AUTO_INCREMENT = 1";

$resultado = @mysqli_query($conexao, $sqlupdate);
if (!$resultado) {
echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' /*. @mysqli_error($conexao)*/); 
} else {

    echo 'Auto increment alterado com sucesso';
}

mysqli_close($conexao);

?>