<?php include_once ('../adm/Vadm.php'); ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../styles/bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
    <link rel="stylesheet" href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/produto.css" />
    <title>Editar Imagens</title>
</head>
<body>

<div style="display: flex;">
<?php
 if (!empty($_GET['erro'])) //Se um erro for encontrado
 {
$erro = $_GET['erro']; //erro = Erro rettornado do arquivo "BDcadastroProduto.php"

$erroMensagem = "";

if ($erro == 1)
{
    $erroMensagem = "Um dos arquivos selecionados não é suportado pelo sistema! Apenas arquivos '.jpg', '.jpeg' e '.png' são suportados.";
}
	echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divErro">- ' . $erroMensagem . '</div></div>';
}

$id = $_GET["id"];

$sqlProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$id'";
$resultadoProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlProduto));

$imagemUrl = $resultadoProduto["imagemUrl"];
$imagem = explode("\n", $imagemUrl);

if($imagemUrl != "") {
for($i = 0; $i < sizeof($imagem); $i++) {
?>
<form method="post" action="BDexcluirImagem.php">
<div class="card" style="width: 18rem;">
    <img src="../imgProdutos/<?php echo $imagem[$i]; ?>" class="card-img-top" alt="..." style="width: 18rem; height: 18rem">
    <div class="card-body">
    <div class="d-grid gap-2">
        <input type="hidden" name="imagem" value="<?php echo $imagem[$i]; ?>"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <button class="btn btn-danger" type="submit">Excluir</button>
    </div>
    </div>
</div>
</form>
<?php } } ?>
</div>

<form method="post" action="BDadicionarImagem.php" enctype="multipart/form-data">
<div class="mb-3">
    <center>
    <input class="form" type="file" name="imagens[]" id="imagemNome" multiple></center>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
  <center>  <button class="btnEnviar" type="submit">Enviar</button></center>
</div>
</form>
<center>
<button class="btnVoltar" type="button" onclick="location.href='editarProduto.php?id=<?php echo $id; ?>'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button>
</center>
</body>
</html>