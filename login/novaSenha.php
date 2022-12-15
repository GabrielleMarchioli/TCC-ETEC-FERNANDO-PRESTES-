<?php $linkBtnVoltar = 'login.php'; ?>

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
    <link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include_once('../styles/Recuperarasenha.css'); ?>
</head>
<form method="post" class="resetPasswordForm">
<div>
<?php
if (!empty($_GET['msg'])) {
    $msg = $_GET['msg']; 

    $Mensagem = "";

    if ($msg == 1)
    {
        $Mensagem = "Senha alterada.";
    }
    else if($msg == 2) {
        $Mensagem = "Erro ao alterar senha.";
    }
    else if($msg == 3) {
        $Mensagem = "Senhas diferentes.";
    }
    else if($msg == 4) {
        $Mensagem = "Token Inválido.";
    }

    echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divErro">- ' . $Mensagem . '</div></div>';
}
?>
</div>
        <h1 class="titulo">RECUPERAÇÃO DA SENHA</h1>
        <div class="divLogin">
            
    <input class="btnEnviar" type="submit" value="Enviar" id="reset" name="reset">
    <label class="lblconfirmarSenha"><input class="txtconfirmarSenha" type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirmar Senha">
    <label class="lblSenha"><input class="txtSenha" type="password" name="senha" id="senha" placeholder="Senha">
            </div>
            </form>
            <center><input class="btnInicio" type="button" value="&#8617" id="cadastrar" name="btnVoltar" onclick="location.href='<?php echo "$linkBtnVoltar"; ?>'"></center>

<?php
include('../conexao.php');
include('./gCrypt.php');

function resetSenha($conexao, $email, $senha) {
    if($senha == md5($_POST['confirmarSenha'])) {
        $sqlUpdateSenha = "UPDATE `usuario` SET `senha` = '$senha' WHERE `email` = '$email';";
        $sqlDeleteEmail = "DELETE FROM `reset` WHERE `email` = '$email'";

        if(mysqli_query($conexao, $sqlUpdateSenha) && mysqli_query($conexao, $sqlDeleteEmail)) {
            return "<script>window.location = '?msg=1'</script>";
        }
        else return "<script>window.location = '?msg=2'</script>";
    }
    else return "<script>window.location = '?msg=3'</script>";
}

if(array_key_exists('token',$_GET)) {
    $email = decrypt(substr($_GET['token'], 0, -32));
    $token = substr($_GET['token'], -32);

    if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($token) == 32) {   
        $sqlEmailToken = "SELECT * FROM `reset` WHERE `email` = '$email' AND `token` = '$token'";
	    $resultadoEmailToken = mysqli_query($conexao, $sqlEmailToken);

        if(mysqli_num_rows($resultadoEmailToken) > 0) { 
            echo '<style>.divLogin { display: block; }</style>';
        }
        else echo "<script>window.location = '?msg=4'</script>";
    }
    else {
        echo "<script>window.location = '?msg=4'</script>";
    }
}
else die();

if(array_key_exists('reset',$_POST)){
	echo resetSenha($conexao, $email, md5($_POST['senha']));
}

?>