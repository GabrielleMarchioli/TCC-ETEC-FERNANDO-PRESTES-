<?php
include_once('../conexao.php');

$nomeUsuario = $_POST['nomeUsuario'];
$sobrenomeUsuario = $_POST['sobrenomeUsuario'];
$emailUsuario = $_POST['emailUsuario'];
$senhaUsuario = $_POST['senhaUsuario'];
//$enderecoUsuario = $_POST['enderecoUsuario'];
$dataUsuario = $_POST['dataUsuario'];
$tipoConta = 3; //Conta do cliente
$statusConta = 0; //E-mail não verificado

$senhaUsuarioMD5 = md5($senhaUsuario); //Criptografar a senha em formato MD5

$sqlUsuario = "SELECT email FROM usuario WHERE email = '$emailUsuario'"; //Procurando por e-mail
$resultadoUsuario = mysqli_query($conexao, $sqlUsuario); //Resultado de quantas linhas foram encontradas para o e-mail digitado
if (mysqli_num_rows($resultadoUsuario) > 0) //Se o e-mail for encontrado
{
    die('<center><h1>Esse endereço de E-mail já está cadastrado,</h1><h2>a conta não foi criada.</h2><h3>Código do erro: #criarConta002</h3><input type="button" value="Voltar" onclick="window. history. back()"></center>');
}

$sqlinsert =  "insert into usuario (nome, sobrenome, email, senha, dataNascimento, tipoConta, statusConta) values ('$nomeUsuario', '$sobrenomeUsuario', '$emailUsuario', '$senhaUsuarioMD5', '$dataUsuario', '$tipoConta', '$statusConta')";

$resultado = @mysqli_query($conexao, $sqlinsert);
if (!$resultado) {
echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' /*. @mysqli_error($conexao)*/); 
 } else {
    $EmailUsuario= mysqli_insert_id($conexao);
    $EmailUsuarioMD5 = md5($emailUsuario);

    header('Location: verificaEmail.php?v=0&id=0&email=' . $EmailUsuarioMD5); //v=0 = E-mail não validado
}

mysqli_close($conexao);

?>