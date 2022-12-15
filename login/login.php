<?php

//Sessão
session_start();

include_once('../conexao.php');

date_default_timezone_set('America/Sao_Paulo');

if (isset($_SESSION['logado'])) // Se o usuário tentar acessar a página de login mas não estiver logado
{
    //O mesmo bloco de código que está no arquivo Vlogin.php foi reescrito aqui ao invés de incluir o Vlogin.php para evitra bugs.
    $idUsuarioSessao = $_SESSION['idUsuario'];
	$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuarioSessao'";
	$resultado = mysqli_query($conexao, $sql);
	$dadosLogin = mysqli_fetch_array($resultado);
//----------------------------------------------------

    if ($dadosLogin['tipoConta'] == 1) //Se for ADM
    {
         header('Location: ../adm/painelControle.php');
    }
    if ($dadosLogin['tipoConta'] == 2) //Se for Entregador
    {
         header('Location: ../entregador/painelEntregador.php');
    }
    if ($dadosLogin['tipoConta'] == 3) //Se for Cliente
    {
         header('Location: ../inicio.php');
    }
}
//$tipoConta = $_POST['nomeUsuario']; Em análise

if(isset($_POST['btnEntrar']))
{
	$erros = array();
	$email = mysqli_escape_string($conexao, $_POST['email']); //Campo do email
	$senha = mysqli_escape_string($conexao, $_POST['senha']); //Campo da senha
    //$tipoConta = $_POST['tipoConta'];
	
	if (empty($email) or empty($senha)) //Veriicar se os campos estão vazios
	{
		$erros[] = "<li>Os campos de E-mail e senha precisam ser preenchidos</li>";
	}
	else //verificando se o e-mail digitado exite
	{
		$sql = "SELECT email FROM usuario WHERE email = '$email'"; //Procurando por email
		$resultado = mysqli_query($conexao, $sql); //Resultado de quantas linhas foram encontradas para o e-mail digitado
		if (mysqli_num_rows($resultado) > 0) //Se o email for encontrado
		{
			$senha = md5($senha); //criptografando a senha
			$sql = "SELECT * FROM usuario  WHERE email = '$email' AND senha = '$senha'"; //Procurando qual é a senha do e-mail encontrado
			$resultado = mysqli_query($conexao, $sql);
			
			if (mysqli_num_rows($resultado) == 1) //Se a senha for encontrada e ela for igual a senha digitada
			{
				$dadosLogin = mysqli_fetch_array($resultado); //Converte resultado em array e atrubui para $dadosLogin
                if ($dadosLogin['statusConta'] == 0) //Se a conta não tiver sido validada
                {
                    $EmailUsuarioMD5 = md5($dadosLogin['email']);
                    die('<center><h1>Essa conta não foi validada e não é possível fazer login.</h1>Para validar sua conta <a href="verificaEmail.php?v=0&id=0&email=' . $EmailUsuarioMD5 . '">clique aqui</a></center>');
                }
                else
                {
                    /*if ($tipoConta != $dadosLogin['tipoConta'])
                    {
                        $erros[] = "<li>O tipo da conta selecionado não corresponde com o tipo cadastrado</li>";
                    }*/
                    
				    $_SESSION['logado'] = true;
                    $_SESSION['idUsuario'] = $dadosLogin['idUsuario'];
                    $idUsuario =  $dadosLogin['idUsuario'];
                    $data = date("Y-m-d H:i:s");
                    $sqlinsert =  "insert into hisLogin (idUsuario, data) values ('$idUsuario', '$data')";
                    $resultado = @mysqli_query($conexao, $sqlinsert);
                    if (!$resultado)
                    {
                        echo '<input type="button" onclick="window.location='."'../inicio.php'".';" value="Voltar"><br><br>';
                        die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                    }
                    
                        if ($dadosLogin['tipoConta'] == 1)
                        {
                            header('Location: ../adm/painelControle.php');
                        }
                        else if ($dadosLogin['tipoConta'] == 2)
                        {
                            header('Location: ../entregador/painelEntregador.php');
                        }
                        else if ($dadosLogin['tipoConta'] == 3)
                        {
                            header('Location: ../inicio.php');
                        }
                }
			}
			else //Se a senha for encontrada e ela for diferente da senha digitada
			{
				$erros[] = "<li>E-mail ou senha inválidos</li>";
			}
		}
		else //Se o email não for encontrado
		{
			$erros[] = "<li>E-mail ou senha inválidos</li>";
		}
	}
	
}
?>

<html lang="pt-br">
<head>
    <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
    <link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include_once('../styles/login.css'); ?>
    <meta charset="UTF-8">
    <title> Login de Usuário </title>
    <meta name="viewport" content="width=device-width">
</head>

<body>

<?php 
if(!empty($erros))
{
	foreach($erros as $erro)
	{
	echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divErro">' . $erro . '</div></div>';
	}
} 

$linkBtnCriarConta = 'criarConta.php';
$linkBtnVoltar = '../inicio.php';

?>
    <form name="frmLogin" action="" method="post">
        <h1 class="titulo">LOGIN</h1>
        <div class="divLogin">
            
            <label class="lblEmail">E-mail:<br></label><input class="txtEmail" type="text" name="email" id="Email"><br>
            <label class="lblSenha">Senha:<br></label><input class="txtSenha" type="password" name="senha" id="senhaid">
            <input type="button" class="btnVis" text="Exibir senha" value="&#128065;" onclick="verSenha()"><br> 
            <a class="aEsqueciSenha" href="recuperarSenha.php">Esqueci a senha</a><br>
            <input class="btnEntrar" type="submit" value="ENTRAR" id="entrar" name="btnEntrar"><br>
            <input class="btnCadastrar" type="button" value="CRIAR CONTA" id="cadastrar" name="btnCadastrar" onclick="location.href='<?php echo "$linkBtnCriarConta"; ?>'">
           

            </div>
            </form>
            <center><button class="btnVlogin" title="Voltar ao início" onclick="location.href='<?php echo "$linkBtnVoltar"; ?>'"><?php include_once('../icones/Arrow_return_left_grande.svg') ?></button></center>
</body>

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

</html>