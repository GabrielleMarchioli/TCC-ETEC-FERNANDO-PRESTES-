<?php

include_once('Vadm.php');
            
include_once('../conexao.php');
$idEntregador = $_GET['idEntregador'];

function updateEntregador($conexao, $id) {
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $email = $_POST["email"];
    $dataNascimento = $_POST["dataNascimento"];

    $sqlEntregador = "UPDATE `usuario` SET `nome` = '$nome', `sobrenome` = '$sobrenome', `email` = '$email', `dataNascimento` = '$dataNascimento' WHERE md5(`idUsuario`) = '$id'";
    if(mysqli_query($conexao, $sqlEntregador))
    {
        ?>
        <?php include_once('../styles/BDeditarEntregador.css'); ?>
        <center><div class='divEditado'><label class='lblEditado' >Entregador editado com Sucesso</label>
        <br>
        <input type='button' class='btnVoltar' text='Voltar' value='Finalizar' onclick="location.href='painelControle.php?aba=entregadores'"></button></div></center>
        <?php
    }
    else return '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br><b>Query Inválida:</b>' . @mysqli_error($conexao);
}

if(array_key_exists('idEntregador', $_GET)) {
    echo updateEntregador($conexao, $idEntregador);
}
?>
