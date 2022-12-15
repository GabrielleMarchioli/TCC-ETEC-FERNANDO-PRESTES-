<?php

include_once('../Vlogin.php');
include_once('Vadm.php'); //Arquivo para verificar se é um adm que está logado

$idPedidoMd5 = $_GET['id'];
$idUslog = $dadosLogin['idUsuario'];
$mensagem = $_POST['motivo'];

date_default_timezone_set('America/Sao_Paulo');
$dataAtual = date('Y/m/d H:i:s');

$queryItemPedido = mysqli_query($conexao, "select ip.idPedidoFk, ip.IdItemPedido, pr.idProduto, ip.quantidade, pr.quantidadeEstoque, ip.idProduto, pr.preco, pr.imagemUrl, pr.nome FROM ItemPedido ip INNER JOIN Produto pr ON ip.idProduto = pr.idProduto where md5(ip.idPedidoFk) = '$idPedidoMd5'");

$qtdItens = mysqli_num_rows($queryItemPedido);

$queryPedido = mysqli_query($conexao, "select * from Pedido where md5(idPedido) = '$idPedidoMd5'");

$dadosPedido=mysqli_fetch_array($queryPedido);

$idPedido = $dadosPedido['idPedido'];

if (isset($_POST['aEntregador'])) //Selecionou um entregador
{
    $idEntregador = $_POST['slctEntregador'];
    $idPedido = $dadosPedido['idPedido'];
    if ($_POST['slctEntregador'] == "n/a")
    {
        $sqlupdate = "update Pedido set idEntregador = 0 where idPedido = $idPedido";
                $resultado = @mysqli_query($conexao, $sqlupdate);
                if (!$resultado)
                {
                    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                }
        header('Location: infoPedido.php?id=' . $idPedidoMd5);
        die ();
    }
    else
    {

        $sqlupdate = "update Pedido set idEntregador = $idEntregador where idPedido = $idPedido";
                $resultado = @mysqli_query($conexao, $sqlupdate);
                if (!$resultado)
                {
                    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                }

        header('Location: infoPedido.php?id=' . $idPedidoMd5 . "&msg=2");
        die ();
    }
} //(if) selecionou um entregador

if (isset($_POST['aceitar']))
{
    if($dadosPedido["status"] == 3) { //Se o pedido foi recusado e está sendo aceito
        $itensDisp; //$itensDisp = Itens estão disponíveis (0 = não|1 = sim)
        $arrQtd = [];
        $arrEstoque = [];
        $arrIdProduto = [];
        while($dadosItemPedido=mysqli_fetch_array($queryItemPedido)) //while 1
        {
            $idProduto = $dadosItemPedido['idProduto'];

            $queryProduto = mysqli_query($conexao, "select * from Produto where idProduto = '$idProduto'");
            $dadosProduto=mysqli_fetch_array($queryProduto);

            if ($dadosProduto['quantidadeEstoque'] < $dadosItemPedido['quantidade'])
            {
                header('Location: infoPedido.php?id=' . $idPedidoMd5 . '&msg=1');
                die("die");
            }

            array_push($arrQtd, $dadosItemPedido['quantidade']);
            array_push($arrEstoque, $dadosItemPedido['quantidadeEstoque']);
            array_push($arrIdProduto, $idProduto);


        }//while
            $idPedido = $dadosPedido['idPedido'];
            $qtdFinal;
            for ($i=0; $i < $qtdItens; $i++)
            {
                $arrIdProdutoFor = $arrIdProduto[$i];
                $qtdFinal = $arrEstoque[$i] - $arrQtd[$i];

                $sqlupdate = "update Produto set quantidadeEstoque = $qtdFinal where idProduto=$arrIdProdutoFor";
                $resultado = @mysqli_query($conexao, $sqlupdate);
                if (!$resultado)
                {
                    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                }
                    //Movimentação
                    $data = date("Y-m-d H:i:s");
                    $obs = "Pedido aceito novamente.";
                    $tipo = 0;
                    $sqlinsert =  "INSERT INTO Movimento (tipo, data, quantidade, observacao, idProduto) VALUES (0, '$data', $arrQtd[$i], '$obs', $arrIdProdutoFor)";
                    $resultado = @mysqli_query($conexao, $sqlinsert);
                    if (!$resultado)
                    {
                        echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                        die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                    }

            } //for

        $sqlupdate =  "update Pedido set mensagem = '$mensagem' where idPedido = $idPedido";
    $resultado = @mysqli_query($conexao, $sqlupdate);
    if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}

    } //Se status pedido == 3
	if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}
    //echo '<script>window.location.reload();</script>';
    $sqlupdate =  "update Pedido set status = 2, dataPedido = '$dataAtual', idUsAlt = $idUslog where idPedido = $idPedido";
    $resultado = @mysqli_query($conexao, $sqlupdate);
    if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}

    header('Location: infoPedido.php?id=' . $idPedidoMd5);
}

if (isset($_POST['recusar']))
{
    $sqlupdate =  "update Pedido set status = 3, dataPedido = '$dataAtual', idUsAlt = $idUslog, mensagem = '$mensagem' where idPedido = $idPedido";
    $resultado = @mysqli_query($conexao, $sqlupdate);
    if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}

    $itensDisp; //$itensDisp = Itens estão disponíveis (0 = não|1 = sim)
    $arrQtd = [];
    $arrEstoque = [];
    $arrIdProduto = [];
    while($dadosItemPedido=mysqli_fetch_array($queryItemPedido)) //while 1
    {
        $idProduto = $dadosItemPedido['idProduto'];

        $queryProduto = mysqli_query($conexao, "select * from Produto where idProduto = '$idProduto'");
        $dadosProduto=mysqli_fetch_array($queryProduto);

        array_push($arrQtd, $dadosItemPedido['quantidade']);
        array_push($arrEstoque, $dadosItemPedido['quantidadeEstoque']);
        array_push($arrIdProduto, $idProduto);

    }//while
        $idPedido = $dadosPedido['idPedido'];
        $qtdFinal;
        for ($i=0; $i < $qtdItens; $i++)
        {
            $arrIdProdutoFor = $arrIdProduto[$i];
            $qtdFinal = $arrEstoque[$i] + $arrQtd[$i];

            $sqlupdate = "update Produto set quantidadeEstoque = $qtdFinal where idProduto=$arrIdProdutoFor";
            $resultado = @mysqli_query($conexao, $sqlupdate);
            if (!$resultado)
            {
                echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
            }
                //Movimentação
                $data = date("Y-m-d H:i:s");
                $obs = "Pedido recusado.";
                $tipo = 0;
                $sqlinsert =  "INSERT INTO Movimento (tipo, data, quantidade, observacao, idProduto) VALUES (1, '$data', $arrQtd[$i], '$obs', $arrIdProdutoFor)";
                $resultado = @mysqli_query($conexao, $sqlinsert);
                if (!$resultado)
                {
                    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                }

        } //for

	if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}
    header('Location: infoPedido.php?id=' . $idPedidoMd5);
}
if (isset($_POST['entregue']))
{
    $sqlupdate =  "update Pedido set status = 4, dataPedido = '$dataAtual', idUsAlt = $idUslog, mensagem = '$mensagem' where idPedido = $idPedido";
    $resultado = @mysqli_query($conexao, $sqlupdate);
    if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}
    header('Location: infoPedido.php?id=' . $idPedidoMd5);
}
if (isset($_POST['desvalidar']))
{
    $sqlupdate =  "update Pedido set status = 2, dataPedido = '$dataAtual', idUsAlt = $idUslog, mensagem = '$mensagem' where idPedido = $idPedido";
    $resultado = @mysqli_query($conexao, $sqlupdate);
    if (!$resultado)
    {
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
	}
   header('Location: infoPedido.php?id=' . $idPedidoMd5);
}

?>