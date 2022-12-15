<?php //editarEstoqueC.php = Editar Estoque Confirmação

include_once '../adm/Vadm.php';

if(!array_key_exists("op", $_POST) || !array_key_exists("id", $_POST)) echo "<script>window.location='../adm/painelControle.php'</script>";

$id = $_POST["id"];
$op = $_POST["op"];
$quantidadeEstoque = $_POST["quantidadeEstoque"];
$nome = $_POST["nome"];

if($quantidadeEstoque <= 0) echo "<script>window.location='../adm/editarEstoque.php?id=$id&erro=8'</script>";

if(!$op) {
$sqlGetEstoque = "SELECT * from `Produto` WHERE md5(`idProduto`) = '$id'";
$resultadoGetEstoque = mysqli_fetch_assoc(mysqli_query($conexao, $sqlGetEstoque));

if($resultadoGetEstoque["quantidadeEstoque"] - $quantidadeEstoque < 0) echo "<script>window.location='editarEstoque.php?id=$id&erro=7'</script>";
}

if($op) { $msg = "adicionar"; $p = "a"; }
else { $msg = "remover"; $p = "de"; }
?>

<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Editar Estoque</title>
</head>
<body>
    <form method="post" action="../adm/BDeditarEstoque.php">
        <center>
        <div class="divExcluir">
            <h3 class="titulo">Você tem certeza de que deseja <?php echo "$msg $quantidadeEstoque itens";?></h3>
            <h3 class="subtitulo"><?php echo "$p: $nome";?></h3>
            <input type='text' class='txtObservacao' name='observacao' id='observacao' placeholder='Digite o motivo da alteração' required/>
            <input type='hidden' name='quantidadeEstoque' id='quantidadeEstoque' value='<?php echo $quantidadeEstoque;?>'/>
            <input type='hidden' name='id' id='id' value='<?php echo $id;?>'/>
            <input type='hidden' name='op' id='op' value='<?php echo $op;?>'/>
            <div>
            <input class="Sim" type="submit" name="btnSim" value="Sim">
            <input class="Nao" type="button" name="btnNao" value="Não" onclick="location.href='../adm/editarEstoque.php?id=<?php echo $id;?>'">
            </div>
        </div>
        </center>
    </form>
</body>
</html>
<style>
 body
    {
       background-position: center;
       background-size: cover;
       background-image: url(../imgs/texturaBranca.jpg);
       background-repeat: no-repeat;
    }
    .divErro
    {
        color: red;
        font-weight: bold;
    }
     .divExcluir
    {
        background-color: #ffffff;
        text-align: center;
        width: 400px;
        height: 270px;
        border: solid 1px #000000;
        margin-top: 240px;
        margin-left: auto;
        margin-right: auto;
    }
    .txtObservacao
    {
        font-family: Arial, sans-serif;
        width: 285px;
        height: 25px;
        font-size: 16px;
        border: none;
        background-color: #e0dcdc;
        margin-top: 2px;
        margin-bottom: 10px;
        margin-left: center;
    }
    .titulo
    {
	    margin-top: 80px;
        font-family: Arial, sans-serif;
        text-align: center;
        cursor: default;
    }
    .titulo
    {
	    margin-top: 80px;
        font-family: Arial, sans-serif;
        text-align: center;
        cursor: default;
    }
  
  .Sim
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    cursor: pointer;
    }
    .Nao
    {
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: bold;
    background-color: #dec890;
    border: solid 1px #000000;
    width: 90px;
    height: 30px;
    cursor: pointer;
    }
      .Sim:hover, .Nao:hover
    {
        background-color: #c2a27c;
    }
    .Sim:active,  .Nao:active
    {
        background-color: #795c39;
        color: #ffffff;
    }
</styles>