<?php include_once ('../adm/Vadm.php'); ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <script src="../styles/bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
    <link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
     <?php include_once('../styles/editarProduto.css'); ?>
    <title>Editar Produto</title>
</head>
<body>
<?php //editarProduto.php = Editar Produto

function getProduto($conexao, $id) {
    $sqlProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$id'";
    $sqlCor = "SELECT * FROM `Cor`";
    $sqlCategoria = "SELECT * FROM `Categoria`";
    $sqlTipo = "SELECT * FROM `Tipo`";
    $resultadoProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlProduto));
    $resultadoCor = mysqli_query($conexao, $sqlCor);
    $resultadoCategoria = mysqli_query($conexao, $sqlCategoria);
    $resultadoTipo = mysqli_query($conexao, $sqlTipo);

    $nome = $resultadoProduto["nome"];
    $descricao = $resultadoProduto["descricao"];
    $preco = $resultadoProduto["preco"];
    $idCategoria = $resultadoProduto["idCategoria"];
    $quantidadeEstoque = $resultadoProduto["quantidadeEstoque"];
    $faixaEtaria = $resultadoProduto["faixaEtaria"];
    $idCor = $resultadoProduto["idCor"];
    $idTipo = $resultadoProduto["idTipo"];
    $tamanho = $resultadoProduto["tamanho"];
    $imagemUrl = $resultadoProduto["imagemUrl"];
    $imagem = explode("\n", $imagemUrl);
    
    ?>
    
    <body>
      <center> <h1 class="titulo">Editar Produto</h1> </center> 
      <div class="DivEditarProduto">
        <form name="FrmProduto" action="../adm/BDeditarProduto.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
<p>
<label class="lblNomeProd">Nome:<br></label><input class="txtNomeProd" type="text" name="nome" id="Nome" placeholder="Nome do Produto" value="<?php echo $nome;?>" required><br>

<label class="lblDescProd"> Descrição do produto:<br></label><textarea class="txtDescProd" required name="descricao" rows="3" cols="21" placeholder="Descrição"><?php echo $descricao;?></textarea>

<label class="lblPrecoProd">Preço do produto:<br></label><input class="txtPrecoProd" value="<?php echo $preco;?>" type="number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" required name="preco" placeholder="Preço">

<label class="lblcategoria">Categoria:<br></label>
<select id="IdSelCategoria" name="idCategoria" class="txtcategoria">
    <?php while($row = mysqli_fetch_assoc($resultadoCategoria)) { ?>
        <option value="<?php echo $row["idCategoria"]; ?>" <?php if($row["idCategoria"] == $idCategoria) echo "selected"; ?>><?php echo $row["nome"]; ?></option>
    <?php } ?>
</select>

<label class="lblfaixaetaria">Faixa Etária:<br></label>
<select id="IdSelFaixaEtaria" name="faixaEtaria" class="txtfaixaetaria">
    <option value="Adulto" <?php if($faixaEtaria == "Adulto") echo "selected"; ?>>Adulto</option>
    <option value="Juvenil" <?php if($faixaEtaria == "Juvenil") echo "selected"; ?>>Juvenil</option>
    <option value="Infantil" <?php if($faixaEtaria == "Infantil") echo "selected"; ?>>Infantil</option>
    <option value="ne" <?php if($faixaEtaria == "ne") echo "selected"; ?>>Não especificado</option> <!--ne = Não especificado-->
</select>

<label class= "lblCor">Cor do Produto:<br></label>
<select id="cor" name="idCor" class="txtCor">
    <?php while($row = mysqli_fetch_assoc($resultadoCor)) { ?>
        <option value="<?php echo $row["idCor"]; ?>" <?php if($row["idCor"] == $idCor) echo "selected"; ?>><?php echo $row["corNome"]; ?></option>
    <?php } ?>
</select>

<label class= "lblTipo">Tipo:<br></label>
<select id="IdSelTipo" name="idTipo" class="txtTipo">
    <?php while($row = mysqli_fetch_assoc($resultadoTipo)) { ?>
        <option value="<?php echo $row["idTipo"]; ?>" <?php if($row["idTipo"] == $idTipo) echo "selected"; ?>><?php echo $row["tipoNome"]; ?></option>
    <?php } ?>
</select>

<label class= "lblTamanho">Tamanho:<br></label>
<select id="tamanho" name="tamanho" class="TxtTamanho">
    <option value="1" <?php if($tamanho == 1) echo "selected"; ?>>P</option>
    <option value="2" <?php if($tamanho == 2) echo "selected"; ?>>M</option>
    <option value="3" <?php if($tamanho == 3) echo "selected"; ?>>G</option>
    <option value="4" <?php if($tamanho == 4) echo "selected"; ?>>GG</option>
    <option value="5" <?php if($tamanho == 5) echo "selected"; ?>>Não especificado</option>
</select>

        <div class="mb-3">
            <input type="button" class="btnEnviar" value="Editar Imagem" onclick="location.href='editarImagem.php?id=<?php echo $id; ?>'">
        </div>

        <div class="mb-3">
            <input type='hidden' name='id' id='id' value='<?php echo $id;?>'/>
            <input type='submit' name='edit' id='edit' value='Enviar' class="btnEnviar"/><br/>
            
        </div>
    </form>

    <?php
    return;
}

if(array_key_exists('id',$_GET)) {
    getProduto($conexao, $_GET['id']);
}
?>
<div class = "divbtnVolta">
  <center><button class="btnVoltar"  name="btnVoltar" onclick="location.href='../adm/painelControle.php?aba=produtos'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button></center>
  </div>
 

</body>
</html>