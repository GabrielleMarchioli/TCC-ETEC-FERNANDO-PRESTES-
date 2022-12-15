<?php

include_once('../conexao.php');
include_once('Vadm.php'); //Arquivo para verificar se é um entregador que está logado

$nomeUsuario = $_POST['nomeUsuario'];
$sobrenomeUsuario = $_POST['sobrenomeUsuario'];
$emailUsuario = $_POST['emailUsuario'];
//$senhaUsuario = $_POST['senhaUsuario'];
$nomeEmpresa = $_POST['nomeEmpresa']; //Endereço sendo usado como nome da empresa.
$tipoConta = 2; // 2 = Entregador
$statusConta = 0; //0 = Email não verificado.

//Criar senha aleatória

$qcds = 7; //qcds = Quantidadede caracteres na senha

  $lma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $lma = Letra maiúsculas
  $lmi = "abcdefghijklmnopqrstuvyxwz"; // $lmi =  letras minúsculas
  $nmrs = "0123456789"; // $nmrs = Números
  $car = "@#$&"; // $car = Caracteres
  
        $PsenhaA = str_shuffle($lma); //PsenhaA = Pré senha Aleatória
        $PsenhaA = str_shuffle($lmi); //PsenhaA = Pré senha Aleatória
        $PsenhaA = str_shuffle($nmrs); //PsenhaA = Pré senha Aleatória
        $PsenhaA = str_shuffle($car); //PsenhaA = Pré senha Aleatória

        $senhaAl = substr(str_shuffle($PsenhaA), 0, $qcds); //$senhaAl = senha Aleatória//Limita a quantidade de caracteres para o valor de $qcds

//$senhaA = senhaA($senha);//$senhaA = senha Aleatória

//echo (senhaA);

//Fim criar senha aleatória


// Modifica a zona de tempo a ser utilizada.
date_default_timezone_set('America/Sao_Paulo');

$DataCriacaoConta = date('Y-m-d');

$senhaUsuarioMD5 = md5($senhaAl); //Criptografar a senha em formato MD5

$sqlUsuario = "SELECT email FROM usuario WHERE email = '$emailUsuario'"; //Procurando por e-mail
$resultadoUsuario = mysqli_query($conexao, $sqlUsuario); //Resultado de quantas linhas foram encontradas para o e-mail digitado
if (mysqli_num_rows($resultadoUsuario) > 0) //Se o e-mail for encontrado
{
    die('<center><h1>Esse endereço de E-mail já está cadastrado,</h1><h2>a conta não foi criada.</h2><h3>Código do erro: #criarContaEntregador002</h3><input type="button" value="Voltar" onclick="window. history. back()"></center>');
}

$sqlinsert =  "insert into usuario (nome, sobrenome, email, senha, endereco, dataNascimento, tipoConta, statusConta) values ('$nomeUsuario', '$sobrenomeUsuario', '$emailUsuario', '$senhaUsuarioMD5', '$nomeEmpresa', '$DataCriacaoConta', '$tipoConta', '$statusConta')";

$resultado = @mysqli_query($conexao, $sqlinsert);
if (!$resultado) {
echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . @mysqli_error($conexao)); 
} else {
    $EmailUsuario= mysqli_insert_id($conexao);
    $EmailUsuarioMD5 = md5($emailUsuario);
    /*
//Enviar dados para verificaEmailEntregador.php

$content = http_build_query(array(
'email' => $emailUsuario,
'senha' => $senhaAl,
));

$context = stream_context_create(array(
'http' => array(
'method' => 'POST',
'content' => $content,
)
));

$result = file_get_contents('https://rclothescem.000webhostapp.com/adm/verificaEmailEntregador.php', null, $context);
header("Location: http://hoo.st");
*/
    header('Location: verificaEmailEntregador.php?email=' . $EmailUsuarioMD5);
}

mysqli_close($conexao);

?>