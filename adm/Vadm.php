<?php //Esse arquivo tem a função de verificar se quem está logado é um administrador
      //Vadm = Verificação de administrador.
    include_once('../Vlogin.php');

    if ($logado == 0) //Não logado
    {
        header('Location: ../index.php');
    }

    else if ($dadosLogin['tipoConta'] != 1) //Está logado mas não é ADM
    {
        header('Location: ../index.php');
    }
?>