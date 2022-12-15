<?php

include_once('../Vlogin.php');
include_once('Vadm.php'); //Arquivo para verificar se é um adm que está logado

$idPedidoMd5 = $_GET['id'];

$queryPedido = mysqli_query($conexao, "select * from Pedido where md5(idPedido) = '$idPedidoMd5'");

$dadosPedido=mysqli_fetch_array($queryPedido);

$idUsAlt = $dadosPedido['idUsAlt'];

$queryIdUsAlt = mysqli_query($conexao, "select * from usuario where idUsuario = $idUsAlt"); //IdUsAlt = Id do usuário que alterou o status por último

$dadosIdUsAlt=mysqli_fetch_array($queryIdUsAlt);
$idUsuario = $dadosPedido['idUsuario'];
$queryUsuPedido = mysqli_query($conexao, "select * from usuario where idUsuario = $idUsuario"); //UsuPedido = Usuário que fez o pedido

$dadosUsuPedido=mysqli_fetch_array($queryUsuPedido);

if ($dadosIdUsAlt['tipoConta'] == 2)
{
    $txtPor = "pelo entregador";
}
else if ($dadosIdUsAlt['tipoConta'] == 1)
{
    $txtPor = "por um administrador";
}
else
{
    $txtPor = "pelo cliente";
}

$queryItemPedido = mysqli_query($conexao, "select ip.quantidade, ip.idProduto, pr.imagemUrl, pr.preco, pr.nome FROM ItemPedido ip INNER JOIN Produto pr ON ip.idProduto = pr.idProduto where md5(ip.idPedidoFk) = '$idPedidoMd5'");
        
        $qtdItens = mysqli_num_rows($queryItemPedido);
        
        $iap = "item adicionado"; //iap = Itens adicionados plural (para deixar texto no plural caso haja mais de 1 item)
        
        if ($qtdItens > 1)
        {
           $iap = "itens adicionados"; 
        }
        
        $statusPedido;
        $iconePedido;
        
        if ($dadosPedido['status'] == 0)
        {
            $statusPedido = 'Pedido não enviado ao vendedor.';
            
           $iconePedido = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
</svg>';

        }
        else if ($dadosPedido['status'] == 1)
        {
            $statusPedido = 'Pedido em análise.';
            
            $iconePedido = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
  <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
</svg>';
        }
        else if ($dadosPedido['status'] == 2)
        {
            $statusPedido = 'Aguardando entrega.';
            
            $iconePedido = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
</svg>';
        }
        else if ($dadosPedido['status'] == 3)
        {
            $statusPedido = 'Não aceito';
            
            $iconePedido = '<svg style="color: red;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart-x-fill" viewBox="0 0 16 16">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7.354 5.646 8.5 6.793l1.146-1.147a.5.5 0 0 1 .708.708L9.207 7.5l1.147 1.146a.5.5 0 0 1-.708.708L8.5 8.207 7.354 9.354a.5.5 0 1 1-.708-.708L7.793 7.5 6.646 6.354a.5.5 0 1 1 .708-.708z"/>
</svg>';
        }
        else if ($dadosPedido['status'] == 4)
        {
            $statusPedido = 'Entregue';
            
            $iconePedido = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
</svg>';
        }

?>

<html>
<head>
<h1 class="titulo">INFORMAÇÕES DO PEDIDO</h1>

<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Judson" />
<link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width">
</head>

<?php include_once('../styles/infoPedido.css'); ?>

<body>

<?php

/*
MENSAGENS QUE PODEM SER RETORNADAS DE OUTRAS PÁGINAS PARA ESTA:
1 - Produto não mais disponível no estoque
2 - Entregador atrubuído com sucesso

*/

if (isset($_GET['msg']))
{
    if ($_GET['msg'] == 2)
    {
        echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divMsg">O entregador foi atribuído com sucesso!</div></div>';
    }
    if ($_GET['msg'] == 1)
    {
        echo '<div class="shadow p-3 mb-5 bg-body rounded"><div class="divMsg">Um dos produtos do pedido não está mais disponível no estoque.</div></div>';
    }
}

?>

<center>
<div class="divinfopedido">
<lable class="status"><?php echo $iconePedido; ?> Status: <?php echo $statusPedido; ?></lable>
<br>

<?php 
$qtdItens = mysqli_num_rows($queryItemPedido);
        
        $iap = "item adicionado"; //iap = Itens adicionados plural (para deixar texto no plural caso haja mais de 1 item)
        
        if ($qtdItens > 1)
        {
           $iap = "itens adicionados"; 
        }

//VIA CEP

$urlViaCep = file_get_contents ("https://viacep.com.br/ws/" . $dadosPedido['cep'] . "/json/");

$ViaCepDecode = json_decode($urlViaCep);

$rua = $ViaCepDecode->logradouro;
$bairro = $ViaCepDecode->bairro;
$localidade = $ViaCepDecode->localidade;
$uf = $ViaCepDecode->uf;

//FIM VIA CEP


$ItensValor;
if ($dadosPedido['frete'] < $dadosPedido['total'])
{
    $ItensValor = $dadosPedido['total'] - $dadosPedido['frete'];
}
else
{
    $ItensValor = $dadosPedido['frete'] - $dadosPedido['total'];
}

$complemento;
if (empty($dadosPedido['complemento']))
{
    $complemento = "Nenhum";
}
else
{
    $complemento = $dadosPedido['complemento'];
}

if (empty($dadosPedido['mensagem']))
{
    $txtObs = "Nenhuma";
}
else
{
    $txtObs = $dadosPedido['mensagem'];
}

?>
<br>

<lable><b>Pedido:</b> <?php echo $qtdItens . " " . $iap; ?></lable>
<br>
<lable class="dataStatus"><b>Última alteração do Status:</b> <?php echo (new DateTime($dadosPedido['dataPedido']))->format('d/m/Y H:i'); ?> <?php echo $txtPor; ?>: <?php echo $dadosIdUsAlt['nome'] . " " . $dadosIdUsAlt['sobrenome'] . (" (") . $dadosIdUsAlt['email'] . ")"; ?></lable>
<br>
<lable><b>Observação do pedido:</b> <?php echo $txtObs; ?></lable>
<br>
<lable><b>Cliente:</b> <?php echo $dadosUsuPedido['nome'] . " " . $dadosUsuPedido['sobrenome'] . " (" . $dadosUsuPedido['email'] . ")"; ?></lable>
<br>

<div class="ConteudoPedido">
        <lable class="TituloConteudo">Conteúdo do pedido:</lable>
        <br>
        <div class="itensPedidoFluido">
            <?php
            $arrPreco = []; //$arrPreco = Array preço
            $arrQtd = []; //$arrQtd = Array Quantidade
            
            while($dadosItemPedido=mysqli_fetch_array($queryItemPedido)) {
                
            array_push($arrPreco, $dadosItemPedido['preco']);    
            array_push($arrQtd, $dadosItemPedido['quantidade']);
            
        $idProdutoMd5 = md5($dadosItemPedido['idProduto']);
                
                    //Capturar a primeira imagem inserida do produto
    
                        
    
                        $PImagemArray = $dadosItemPedido['imagemUrl'];//$PImagem = Primeira imagem (Array)
                        $urlImagem;
                        if (empty($PImagemArray[0]))
                        {
                           $PImagem = "semImagens.png";
                           $urlImagem = "../imgs/";
                        }
                        else
                        {
                            $PImagemArraylinha1 = explode("\n",$PImagemArray);
                            $PImagem = $PImagemArraylinha1[0];
                            $urlImagem = "../imgProdutos/";
                        }
                        
                    //Fim de capturar a primeira imagem inserida do produto
                ?>
                
                <a href="editarProduto.php?id=<?php echo $idProdutoMd5; ?>">
                <div class="itemPedido">
                    <div class="conteudoItemPedido">
                    <img src="<?php echo $urlImagem . $PImagem; ?>" class="imgImagemProduto" alt="Responsive image">
                    
                    <center><lable class="infoProduto">x<?php echo $dadosItemPedido['quantidade']; ?> <?php echo $dadosItemPedido['nome']; ?>
                    <br>
                    R$ <?php echo  number_format($dadosItemPedido['preco'],2,",",".");?> </lable>
                    <br>
                    <?php if ($dadosPedido['status'] == 0){?>
                    <form method="post" action="BDexcluirItemLista.php?idItem=<?php echo md5($dadosItemPedido['IdItemPedido']) . "&idPedido=" . md5($dadosPedido['idPedido']); ?>">
                    <input class= "btnRemover" type="submit" value="Remover">
                    </form>
                    <?php } ?>
                    </center>
                    </div> <!--conteudoItemPedido-->
                    </div> <!--Item pedido-->
                    </a>
        <?php }//while  ?>
        </div><!--itensPedidoFluido-->
        </div> <!--ConteudoPedido-->
<lable><b>Itens do pedido:</b> <i>R$ <?php echo number_format($ItensValor,2,",","."); ?></i></lable>
<br>
<lable><b>Frete:</b> <i>R$ <?php echo number_format($dadosPedido['frete'],2,",","."); ?></i></lable>
<br>
<lable><b>Total:</b> <i>R$ <?php echo number_format($dadosPedido['total'],2,",","."); ?></i></lable>
<br>
<lable><b>Endereço de entrega:</b> <?php echo $rua . ", N°" . $dadosPedido['numero'] . ", " . $bairro . ", " . $localidade . " - " . $uf; ?></lable>
<br>
<lable><b>CEP de entrega:</b> <?php echo $dadosPedido['cep']; ?></lable>
<br>
<lable><b>Complemento:</b> <?php echo $complemento; ?></lable>
<br>
<a class="btn btn-outline-secondary" href="../msg.php?id=<?php echo $idPedidoMd5;?>">Chat</a>

<?php

if ($dadosPedido['status'] == 2 || $dadosPedido['status'] == 4)
{
    $idEntregador = $dadosPedido['idEntregador'];

$queryEntregador = mysqli_query($conexao, "select * from usuario where tipoConta = 2");
?>
<form method="post" action="BDinfoPedido.php?id=<?php echo $idPedidoMd5 ; ?>">
<select class="slctEntregador">

<option value="n/a" title="Nenhum">Nenhum</option>
<?php while($dadosEntregador=mysqli_fetch_array($queryEntregador)) { ?>

<option value="<?php echo $dadosEntregador['idUsuario']; ?>" title="E-mail: <?php echo $dadosEntregador['email']; ?>" <?php if($idEntregador == $dadosEntregador['idUsuario']) echo "selected"; ?>><?php echo $dadosEntregador['nome'] . " " . $dadosEntregador['sobrenome']; ?></option>

<?php } ?>
</select>
<input type="submit" class="btnAentregador" name="aEntregador" class="aEntregador" value="Atribuir ao entregador">
</form>

<?php } ?>

<form action="BDinfoPedido.php?id=<?php echo $idPedidoMd5; ?>" method="post">
<?php if ($dadosPedido['status'] == 1){?>

<input  class="btnEnviar" type="submit" name="aceitar" value="Aceitar pedido">
<input   class="btnEnviar" type="submit" name="recusar" value="Recusar pedido">
<br>
<br>
Insira uma observação: <input type="text" name="motivo" required>

<?php } if ($dadosPedido['status'] == 2) {?>

<input class="btnEnviar" type="submit" name="entregue" value="Validar como entregue"><br>
<input class="btnRemover" type="submit" name="recusar" value="Recusar pedido">
<br>
<br>
<b>Insira uma observação:</b> <input class="txtobs"type="text" name="motivo" required>

<?php } if ($dadosPedido['status'] == 3) {?>

<input class="btnEnviar" type="submit" name="aceitar" value="Aceitar pedido">
<br>
<br>

<?php } if ($dadosPedido['status'] == 4) {?>

<input class="btnRemover" type="submit" name="desvalidar" value="Desvalidar entrega">
<br>
<br>
</div>
<?php }?>
</form>
<br>
<button class="btnVoltar" onclick="location.href='index.php'"><?php include_once('../icones/Arrow_return_left_grande.svg'); ?></button>

</center>

</body>

</html>