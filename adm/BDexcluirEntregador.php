<?php

include_once('Vadm.php');
            
	include_once('../conexao.php');
	$idEntregador = $_GET['idEntregador'];
	
	$sqldelete =  "delete from  usuario where md5(idusuario) = '$idEntregador ' ";
	
	// executando instrução SQL
	$resultado = @mysqli_query($conexao, $sqldelete);
	if (!$resultado) {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	} else {
	    ?>
        <?php include_once('../styles/BDeditarEntregador.css'); ?>
        <center><div class='divEditado'><label class='lblEditado' >Entregador excluído com Sucesso</label>
        <br>
        <input type='button' class='btnVoltar' text='Voltar' value='Finalizar' onclick="location.href='painelControle.php?aba=entregadores'"></button></div></center>
        <?php
	} 
	mysqli_close($conexao);

?>
