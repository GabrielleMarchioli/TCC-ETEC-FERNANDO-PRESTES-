<?php

include_once('../conexao.php');

$linkBtnVoltar = 'login.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <link href="/styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <?php include_once('../styles/cadastroCliente.css'); ?>
        <meta charset="UTF-8">
        <title>RClothes | Criar conta</title>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <form method="POST" action="BDcriarConta.php">

    <h1 class="titulo">CADASTRO</h1>
              <div class="divCadastro">
        <label class="lblNome">Nome:<br></label><input class="txtNome" type="text" name="nomeUsuario" id="Nome" required><br>
        <label class="lblSobrenome">Sobrenome:<br></label><input class="txtSobrenome" type="text" name="sobrenomeUsuario" id="Sobrenome"><br>
        <label class="lblEmail">E-mail:<br></label><input class="txtEmail" type="text" name="emailUsuario" id="Email" required><br>
        <label class="lblSenha">Senha:<br></label>
        <input class="txtSenha" type="password" name="senhaUsuario" id="senhaid" required<br><input type="button" class="btnVis" text="Exibir senha" value="&#128065;" onclick="verSenha()">
        <!--<label class="lblEndereco">Endereço:<br></label><input class="txtEndereco" type="text" name="enderecoUsuario" id="Endereço" required><br>-->
        <label class="lblData">Data de nascimento:<br></label>
        <input class="txtData" type="date" name="dataUsuario" id="Data" required><br>
        <input class="btnCadastrar" type="submit" value="Cadastrar" id="cadastrar" name="btnCadastrar"       
        

       
       
        <div class="divBtn">
        <input class="btnLimpar" type="reset" value="Limpar" id="limpar" name="btnLimpar"><br>
          <center><button class="btnVlogin" type="button" title="Voltar à página de login" onclick="location.href='<?php echo "$linkBtnVoltar"; ?>'"><?php include_once('../icones/Arrow_return_left_grande.svg') ?></button></center>

        </div>
        
       </div>
    </form>
  
    </body>
</html>

<script language="Javascript">

    function verSenha ()
    {
        var senha1 = document.getElementById("senhaid");
        
        if (senha1.type == "password")
        {
            senhaid.type = ("text");
        }
        else
        {
            senhaid.type = ("password");
        }
    }
    
</script>