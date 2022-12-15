<?php //pcs = produto cadastrado com sucesso

//-------------Criar Vadm-------------\\

    include_once('../../Vlogin.php');

    if ($logado == 0) //Não logado
    {
        header('Location: ../index.php');
    }

    else if ($dadosLogin['tipoConta'] != 1) //Está logado mas não é ADM
    {
        header('Location: ../index.php');
    }

//-------------Fim criar Vadm----------\\

include_once('../../styles/pcs.css');

$linkBtnFN = '../painelControle.php?aba=produtos'; //$linkBtnFN = Link do botão de FiNalizar

?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <title>Sucesso!</title>
    </head>
    
    <body>

    <center>
    <h1>Produto cadastrado com sucesso!</h1>
    <br><hr>
    <button class="btnFinalizar" onclick="location.href='<?php echo "$linkBtnFN"; ?>'">Finalizar</button></center>
        
    </body>