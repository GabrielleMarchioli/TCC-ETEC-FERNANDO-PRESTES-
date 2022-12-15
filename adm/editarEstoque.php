<?php include_once ('../adm/Vadm.php'); ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../styles/bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
    <link rel="stylesheet" href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/editarEstoque.css" />
    <?php include_once('../styles/editarEstoque.css'); ?>
    <title>Editar Estoque</title>
</head>
<body>

<div style="display: flex; flex-direction: column;">
<?php
 if (!empty($_GET['erro'])) //Se um erro for encontrado
 {
$erro = $_GET['erro']; //erro = Erro rettornado do arquivo "BDcadastroProduto.php"

$erroMensagem = "";

if ($erro == 1) {
    $erroMensagem = "Um dos arquivos selecionados não é suportado pelo sistema! Apenas arquivos '.jpg', '.jpeg' e '.png' são suportados.";
}
else if($erro == 7) $erroMensagem = "Quantidade inválida.";
else if($erro == 8) $erroMensagem = "A quantidade tem que ser maior que 0.";
else $erroMensagem = "Erro inválido.";

echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divErro">- ' . $erroMensagem . '</div></div>';
}

function getEstoque($conexao, $id) {
$sqlProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$id'";
$resultadoProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlProduto));
$nome = $resultadoProduto["nome"];
$quantidadeEstoque = $resultadoProduto["quantidadeEstoque"];
?>
<center> <h1 class="titulo">Editar Estoque</h1> </center> 
<div class="DivEditarProduto">
<h5>Produto: <?php echo $nome; ?></h5>
<h5>Quantidade atual: <?php echo $quantidadeEstoque; ?></h5>
<form method="post" action="editarEstoqueC.php" id="frmEstoque">
    <div class="mb-3">
        <label class="lblDescProd"> Quantidade:<br></label>
        <input class="txtNomeProd" type="number" name="quantidadeEstoque" id="quantidadeEstoque" placeholder="Quantidade a adicionar ou remover" required><br>
    </div>
    <div class="mb-3">
        <input type='hidden' name='nome' id='nome' value='<?php echo $nome;?>'/>
        <input type='hidden' name='id' id='id' value='<?php echo $id;?>'/>
        <input type='hidden' name='op' id='op'/>
        <button type='button' class="btnEnviar" onclick="adicionar();">Adicionar</button>
        <button type='button' class="btnEnviar" onclick="remover();">Remover</button><br/>
    </div>
</form>
</div>
<?php return; }

if(array_key_exists("id", $_GET)) {
    getEstoque($conexao, $_GET["id"]);
}
?>

<div class = "divbtnVolta">
  <center><button class="btnVoltar"  name="btnVoltar" onclick="location.href='painelControle.php?aba=produtos'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button></center>
</div>

<script>
function adicionar() {
    document.getElementById("op").value = 1;
    document.getElementById("frmEstoque").submit();
}

function remover() {
    document.getElementById("op").value = 0;
    document.getElementById("frmEstoque").submit();
}

</script>

</body>
</html>