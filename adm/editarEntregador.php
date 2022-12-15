<?php //editarEntregador.php = Editar Entregador

include_once ('../adm/Vadm.php');

$idEntregador = $_GET['idEntregador'];


function getEntregador($conexao, $id) {
    $sqlEntregador = "SELECT * FROM `usuario` WHERE md5(`idUsuario`) = '$id'";
    $resultadoEntregador = mysqli_fetch_assoc(mysqli_query($conexao, $sqlEntregador));

    $nome = $resultadoEntregador["nome"];
    $sobrenome = $resultadoEntregador["sobrenome"];
    $email = $resultadoEntregador["email"];
    $dataNascimento = $resultadoEntregador["dataNascimento"];
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <link href="/styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <?php include_once('../styles/editarEntregador.css'); ?>
        <title>Editar Entregador</title>
    </head>
    <body>
        <center><h1 class="titulo">Editar Entregador</h1></center>
        <div class="diveditarEntregador"
        <center><div name="Editar" class"divEditar">
    <form method='post' action='../adm/BDeditarEntregador.php?idEntregador=<?php echo $id;?>' 
    class='editEntregadorForm'>
     <label class="lblNome">Nome do entregador: <br></label><input class="txtNome" type='text' name='nome' id='nome' placeholder='Nome' value='<?php echo $nome;?>'/>
    <label class="lblSobrenome">Sobrenome do entregador: <br></label><input class="txtSobrenome" type='text' name='sobrenome' id='sobrenome' placeholder='Sobrenome' value='<?php echo $sobrenome;?>'/>
    <label class="lblEmail">Email do entregador: <br></label><input class="txtEmail" type='email' name='email' id='email' placeholder='Email' value='<?php echo $email;?>'/>
    <label class="lblData">Data de nascimento: <br></label><input class="txtData" type='date' name='dataNascimento' id='dataNascimento' placeholder='Data de Nascimento' value='<?php echo $dataNascimento;?>'/>
    <input type='hidden' name='id' id='id' value='<?php echo $id;?>'/>
    </div></center>
    <div>
     <center><input class="btnEnviar" type='submit' name='edit' id='edit' value='Enviar'/><br/></center>
     </div>
    </form>
         <center><button class="btnVoltar"  name="btnVoltar" onclick="location.href='painelControle.php?aba=entregadores'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button></center>
    </body>

    <?php
    return;
}

if(array_key_exists('idEntregador',$_GET)) {
    getEntregador($conexao, $idEntregador);
}
?>

