<html lang="pt-br">
    <head>
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <?php include_once('../styles/verificaEmail.css'); ?>
		<title>Valide a conta</title>
        <meta charset="UTF-8">
    </head>
</html>

<?php

include_once('../conexao.php');

//Recuperando da URL
$email = $_GET['email'];


	$sql = "SELECT * FROM usuario WHERE MD5(email) = '$email'";
	$resultado = mysqli_query($conexao, $sql);
	$dadosLoginVm = mysqli_fetch_array($resultado); //$dadosLoginVm = $dadosLogin da verificação de E-mail
	$emailUsuario = $dadosLoginVm['email'];
	$EmailUsuarioMD5 = md5($dadosLoginVm['email']);
	$idUsuarioMD5 = md5($dadosLoginVm['idUsuario']);

	$assuntoEmail = "RCLOTHES - Validação de conta";
    $link = "login/verificaEmail.php?v=1&email=0&id=" . $idUsuarioMD5; //v=1 = E-mail validado
    $mensagemEmail = "Você criou uma conta RCLOTHES. Para validar sua conta clique aqui: https://rclothescem.000webhostapp.com/" . $link . " Caso contrário, não será possível fazer login.";

    $linkBtnVoltarPainel = '../adm/painelControle.php?aba=entregadores';

	mail($emailUsuario, $assuntoEmail, $mensagemEmail);
	?>
    <center><h2 class="titulo">A conta do entregador foi criada, porém prescisamos que ele(a) valide-a pelo E-mail que foi enviado para:  "<?php echo $emailUsuario; ?>"<br>
    <h3 class="titulo2">Por favor, peça que o entregador valide o E-mail, caso contrário, ele não poderá fazer login
    <h4 class="titulo3">Você já pode fechar essa página</h4>
    <input type="button" value="Voltar ao Painel de controle" onclick="location.href='<?php echo "$linkBtnVoltarPainel"; ?>'"></center> Para reenviar o e-mail <a href="verificaEmailEntregador.php?v=0&id=0&email=<?php echo $EmailUsuarioMD5; ?>">clique aqui</a> ou atualize a página.