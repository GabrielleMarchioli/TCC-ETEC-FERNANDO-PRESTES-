<?php //excluirEntregadorC.php = Excluir Entregador Confirmação

    include_once ('../adm/Vadm.php');

$idEntregador = $_GET['idEntregador'];

?>

<html lang="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Excluir entrgador</title>
<body>
    <form method="post" action="../adm/BDexcluirEntregador.php?idEntregador=<?php echo $idEntregador; ?>">
    <center><div class="divExcluir">
<h3 class="titulo">Deseja excluir permanentemente o entregador selecionado?</h3>
<input class="Sim" type="submit" name="btnSim" value="Sim">
<input class="Nao" type="button" name="btnNao" value="Não" onclick="location.href='../adm/'">
</div></center>
</form>
</body>
</html>
<style>
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
     .divExcluir
    {
        background-color: #ffffff;
        text-align: center;
        width: 400px;
        height: 220px;
        border: solid 1px #000000;
        margin-top: 240px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 10px;
        box-shadow: 5px 5px 5px black;
    }
     .titulo
    {
	    margin-top: 80px;
        font-family: Arial, sans-serif;
        text-align: center;
        cursor: default;
    }
  
  .Sim
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    cursor: pointer;
    border-radius: 8px;
    }
    .Nao
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    cursor: pointer;
    border-radius: 8px;
    }
      .Sim:hover, .Nao:hover
    {
        background-color: #c2a27c;
    }
    .Sim:active,  .Nao:active
    {
        background-color: #795c39;
        color: #ffffff;
    }
</styles>