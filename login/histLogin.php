<?php
include_once('../Vlogin.php');

$idUsuario = $dadosLogin['idUsuario'];

if ($logado == 0)
{
    header("Location: ../inicio.php");
    die();
}

$queryHisLogin = mysqli_query($conexao, "select * from hisLogin where idUsuario = $idUsuario order by idHisLogin desc");
        
		if (!$queryHisLogin)
		{
            $PProduto = $_GET['PProduto'];
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida: </b>' . @mysqli_error($conexao));  
	    }

        $qtdLogins = mysqli_num_rows($queryHisLogin);

?>

<html>

<head>

<title>Histórico de login</title>
<link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Judson" />
<meta name="viewport" content="width=device-width">

</head>

<?php include_once('../styles/histLogin.css'); ?>

<body>

<center>

<h1 class="titulo">Histórico de login</h1>
<h4><?php include_once('../icones/People_circle.svg');?> <?php echo $dadosLogin['email']; ?></h4>

<lable><b>Quantidade de login do usuario:</b> <?php echo $qtdLogins; ?></lable>
<br><br>

<button class="btnVoltar" onclick="location.href='../index.php'"><?php include_once('../icones/Arrow_return_left_grande.svg'); ?></button>

<!--Tabela-->

<table class="table">
  <thead>
    <tr>
      <th scope="col">Data de login</th>
    </tr>
  </thead>
  <tbody>
  <?php while($dadosHisLogin=mysqli_fetch_array($queryHisLogin)) { ?>
    <tr>
      <td><?php echo (new DateTime($dadosHisLogin['data']))->format('d/m/Y H:i'); ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<!--Fim da tabela-->

</center>

</body>

</html>