<?php

include_once('../Vlogin.php');
include_once('Vadm.php'); //Arquivo para verificar se é um entregador que está logado

    $linkBtnVoltar = "painelControle.php?aba=entregadores";

    ?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <link href="/styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Judson" />
         <?php include_once('../styles/cadastroEntregador.css'); ?>
        <title>Criar entregador</title>
        
    </head>
    <body>
         <center><h1 class="titulo">Cadastrar Novo Entregador</h1></center>
         <div class="divCadastroEntregador">
        <form name="frmCriarEntregador" action="BDcadastroEntregador.php" method="post">
        <center> <div name="divEntregador" class"divEntregador">
          <align>   
        <label class="lblNomeEntregador">Nome do entregador: <br></label><input class="txtNomeEntregador" type="text" value="" name="nomeUsuario" placeholder="Nome" required>
        <label class="lblSobrEntregador">Sobrenome: <br></label><input class="txtSobrEntregador" type="text" value="" name="sobrenomeUsuario" placeholder="Sobrenome" required>
        <label class="lblEmailEntregador">Email: <br></label><input class="txtEmailEntregador" type="email" value="" name="emailUsuario" placeholder="E-mail" required>
        <label class="lblEmpresaNome">Nome da empresa: <br></label><input class="txtEmpresaNome" type="text" value="" name="nomeEmpresa" placeholder="Nome da empresa de entrega">
        <div><center>
        <input class="btnLimpar" type="reset" value="Limpar">
        <input class="btnCriar" type="submit" value="Criar">
        </div></center>
        </div> </center></align>
    </form>
     <center><button class="btnVoltar"  name="btnVoltar" onclick="location.href='<?php echo "$linkBtnVoltar"; ?>'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button></center>
</body>
</html>

<style>
 body
    body {
        background-position: center;
        background-size: cover;
        background-color: rgb(201, 199, 199);
        /*background-size: 100%;*/
        
    }  

    .divErro
    {
        color: red;
        font-weight: bold;
    }
     .divEntregador
    {
        background-color: #ffffff;
        text-align: center;
        width: 350px;
        height: 620px;
        border: solid 1px #000000;
        margin-top: auto;
        margin-left: auto;
        margin-right: auto;
        box-shadow: 10px 5px 5px black;
    }
     .titulo
    {
	    margin-top: 150px;
        font-family: Judson;
        text-align: center;
        cursor: default;
    }

         .nomeEntregador
    {
        font-family: Arial, sans-serif;
        width: 285px;
        height: 45px;
        font-size: 25px;
        border: none;
        background-color: #e0dcdc;
    }
    .btnVoltar:active
    {
        background-color: #795c39;
        color: #ffffff;
    }
    .btnVoltar
    {
    font-family: Arial, sans-serif;
    font-size: 23px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 50px;
    cursor: pointer;
    margin-top: 10px;
    }
    .btnCriar
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    margin-top:30px;
    cursor: pointer;
    }
    .btnLimpar
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    cursor: pointer;
}
</style>