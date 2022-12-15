<?php

include_once('Vadm.php');

$linkbtnVoltar = 'painelControle.php?aba=produtos';

 if (!empty($_GET['erro'])) //Se um erro for encontrado
 {
$erro = $_GET['erro']; //erroo = Erro rettornado do arquivo "BDcadastroProduto.php"

$erroMensagem = "";

if ($erro == 1)
{
    $erroMensagem = "Um dos arquivos selecionados não é suportado pelo sistema! Apenas arquivos '.jpg', '.jpeg' e '.png' são suportados.";
}
	echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divErro">- ' . $erroMensagem . '</div></div>';
}

?>

<html lang="pt-br">

    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <link href="/styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Judson"/>
        <?php include_once('../styles/cadastroPoduto.css'); ?>
        <title>Cadastro de produto</title>
    </head>
    
    <body>
      <center> <h1 class="titulo">Cadastrar Novo Produto</h1> </center> 
      <div class="divCadastroProduto">
        <form name="FrmProduto" action="BDcadastroProduto.php" method="post" enctype="multipart/form-data">
<p>
<label class="lblNomeProd">Nome:<br></label><input class="txtNomeProd" type="text" name="nomeProduto" id="Nome" placeholder="Nome do Produto" required><br>

<label class="lblDescProd">Descrição do produto:<br></label><textarea class="txtDescProd" required name="descricaoProduto" rows="3" cols="21" placeholder="Descrição"></textarea>

<label class="lblPrecoProd">Preço do produto:<br></label><input class="txtPrecoProd" type="number" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" required name="precoProduto" placeholder="Preço">

<label class="lblQuantEstoque">Quantidade de estoque:<br><input class="txtQuantEstoque" type="number" required name="quantidadeEstoque" placeholder="Quantidade inicial de estoque">

<label class="lblcategoria">Categoria:<br></label><select class="txtcategoria" name="categoriaProduto">
    
    <option value="1">Feminino</option>
    <option value="2">Masculino</option>
    <option value="3" selected>Não especificado</option> <!--ne = Não especificado -->
    
</select>

<label class="lblfaixaetaria">Faixa Etária:<br></label><select class="txtfaixaetaria" name="faixaEtaria">

    
    <option value="Adulto">Adulto</option>
    <option value="Juvenil">Juvenil</option>
    <option value="Infantil">Infantil</option>
    <option value="ne" selected>Não especificado</option> <!--ne = Não especificado-->
    
</select> 

<label class= "lblCor">Cor do Produto:<br></label><select class="txtCor" name="corProduto">
    
    <option value="1">Preto</option>
    <option value="2">Cinza</option>
    <option value="3">Branco</option>
    <option value="4">Marrom</option>
    <option value="5">Azul</option>
    <option value="6">Verde</option>
    <option value="7">Amarelo</option>
    <option value="8">Laranja</option>
    <option value="9">Vermelho</option>
    <option value="10">Rosa</option>
    <option value="11">Roxo</option>
    <option value="12" selected>Não especificado</option> <!--na = Não especificado-->

</select>

<label class= "lblTipo">Tipo:<br></label><select class="txtTipo" name="TipoProduto">
    
    <option value="1">Camisas</option>
    <option value="2">Vestidos</option>
    <option value="3">Gravatas</option>
    <option value="4">Calças</option>
    <option value="5">Meias</option>
    <option value="6">Cintos</option>
    <option value="7">Ternos</option>
    <option value="8" selected>Não especificado</option> <!--na = Não especificado-->
    
</select>

<label class= "lblTamanho">Tamanho:<br></label><select class="txtTamanho" name="tamanhoProduto">
    
    <option value="1">P</option>
    <option value="2">M</option>
    <option value="3">G</option>
    <option value="4">GG</option>
    <option value="5" selected>Não especificado</option> <!--na = Não especificado-->
    
</select>

<label class="lblImagem">Importar imagem do produto:<br><input class="txtImagem" type="file" name="imagens[]" id="imagemNome" multiple>
</p>
<p>
<center>
<div class="divBtn">
<input class="btnCadastrar" type="submit" value="Cadastrar">
<input class="btnLimpar" type="reset" value="Limpar" onclick="document.FrmProduto.nomeProduto.focus()">
</div class = "divBtn">
</center></p>




</form>
        <div class= "divBtnVoltar"
         <center><button class="btnVoltar"  name="btnVoltar" onclick="location.href='<?php echo "$linkbtnVoltar"; ?>'"><?php include_once('../icones/Arrow_return_left_grande.svg');?></button></center>
    
    </body>

    </html>
