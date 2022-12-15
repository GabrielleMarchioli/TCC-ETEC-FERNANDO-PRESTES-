<?php
        include_once('../Vlogin.php');
        include_once('Vadm.php'); //Arquivo para verificar se é um adm que está logado
        include_once(__DIR__ . '/../' . "/alertas.php");
   
        $linkBtnCCE = 'cadastroEntregador.php'; // $linkBtnCCE = Link do botão de Criar Conta para o Entregador
        $linkBtnCP = 'cadastroPoduto.php'; // $linkBtnCP =  Link do botão de Cadastrar Produto
        //Código para manipular link do botão de logoff
        $linkBtnExcluir = '../adm/excluirEntregadorC.php?idEntregador='; //Parte do link para abrir página de exclusão de entregador
        $linkBtnEditar = '../adm/editarEntregador.php?idEntregador='; //Parte do link para abrir página de edição de entregador
        
            $linkBtnLogin = '../login/logoff.php';
            //FIM do Código para manipular link do botão de logoff

            $nomeUsuarioLogado = $dadosLogin['nome'];
            $idUsuarioLogado = $dadosLogin['idUsuario'];
            
            //---------------Para criar variável $dadosPedido posteriomente---------------\\
            
            $queryPedido = mysqli_query($conexao, "select * from Pedido where status !=0 order by idPedido");
            
            //---------------Fim de Para criar variável $dadosPedido posteriomente---------------\\
            
               //---------------Para criar variável $dadosEntregador posteriomente---------------
    $PENA = "";//PENA = Pesquisa de entregador (entregador não encontrado) - exibe mensagem de funcionario não encontrado.
    if (!empty($_GET['PEntregador'])) //Se um entregador for pesquisado
   {
       $PEntregador = $_GET['PEntregador'];//Recuperar o entregador digitado que está na URL
        $queryEntregador = mysqli_query($conexao,"select * from usuario where tipoConta = 2 and email like '%$PEntregador%' and tipoConta = 2 or nome like '%$PEntregador%' and tipoConta = 2 or sobrenome like '%$PEntregador%' and tipoConta = 2 order by idUsuario");
        
		if (mysqli_num_rows($queryEntregador) < 1)
		{
		    $PENA = "O Entregador pesquisado não foi encontrado";
		}
        
   }  
   else//Se um entregador NÃO for pesquisado
   {
        $queryEntregador = mysqli_query($conexao,"select * from usuario where tipoConta = 2 order by idUsuario");
        $PEntregador = ""; //Se não houver entregador digitado (Valor usado para preencher a caixa de pequisa de entregador)
   }
	if (!$queryEntregador) {
	    $PEntregador = "";
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>' . @mysqli_error($conexao));  
	}
	        //---------------Fim de "para criar variável $dadosEntregador posteriomente"---------------
            
            //---------------Para criar variável $dadosProduto posteriomente---------------
    $PPNA = "";//PENA = Pesquisa de produto (produto não encontrado) - exibe mensagem de produto não encontrado.
    $txtPPNA = "O Produto pesquisado não foi encontrado!<br>Tente usar palavras diferentes ou alterar os filtros.";//$txtPPNA = Texto da variável $PPNA.

    if (!empty($_GET['PProduto'])) //Se um produto for pesquisado
    {
       $PProduto = $_GET['PProduto'];
       
       if ($_GET['VtJs'] == 8 && $_GET['VcJs'] == 3) //Não há filtros mas há pesquisa
       {
            $VtJs = $_GET['VtJs'];//Recuperar o tipo selecionado que está na URL
            $VcJs = $_GET['VcJs']; //Recuperar a categoria selecionada que está na URL
            $queryProduto = mysqli_query($conexao, "select * from Produto where nome like'%$PProduto%' or descricao like '%$PProduto%' order by idProduto");
        
		if (!$queryProduto)
		{
            $PProduto = $_GET['PProduto'];
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida:</b>');  
	    }
	        
		if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
		{
		    $PPNA = $txtPPNA;
		}
       }
        if (!empty($_GET['VtJs']) && $_GET['VtJs'] < 8 && !empty($_GET['VcJs']) && $_GET['VcJs'] < 3)//Filtro para VtJs e VcJs.
       {
            $VtJs = $_GET['VtJs'];//Recuperar o tipo selecionado que está na URL
            $VcJs = $_GET['VcJs']; //Recuperar a categoria selecionada que está na URL
            $queryProduto = mysqli_query($conexao, "select * from Produto where idTipo like $VtJs and idCategoria like $VcJs and nome like '%$PProduto%' or descricao like '%$PProduto%' and idTipo like $VtJs and idCategoria like $VcJs order by idProduto");
        
		if (!$queryProduto)
		{
            $PProduto = $_GET['PProduto'];
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida:</b>');  
	    }
	        
		if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
		{
		    $PPNA = $txtPPNA;
		}
       }//filtro VtJs e VcJs
       else if (!isset($_GET['VtJs']) or $_GET['VtJs'] == 8 && isset($_GET['VcJs']) && $_GET['VcJs'] <3) //Se o tipo não for filtrado e a categoria categoria for.
       {
           $VtJs = 8; //Valor do select "tipo" se houver pesquisa
           $VcJs = $_GET['VcJs']; //Valor do select categoria se houver pesquisa
        $queryProduto = mysqli_query($conexao,"select * from Produto where nome like '%$PProduto%' and idCategoria like $VcJs or descricao like '%$PProduto%' and idCategoria like $VcJs order by idProduto");
        $PProduto = $_GET['PProduto']; //Se houver produto digitado (Valor usado para preencher a caixa de pequisa de produto)

	if (!$queryProduto) {
	    $PProduto = $_GET['PProduto'];
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
	if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
	{
	    $PPNA = $txtPPNA;
	}
       }//If -empty($_GET['VtJs']) 
   // or !isset($_GET['VtJs']) && !isset($_GET['VcJs'])
   else if (!isset($_GET['VcJs']) or $_GET['VcJs'] = 3 && isset($_GET['VtJs']) && $_GET['VtJs'] < 8)//Se a categoria não for filtrada, mas o tipo for.
   {
       $VtJs = $_GET['VtJs'];
       $VcJs = 3;
        $queryProduto = mysqli_query($conexao,"select * from Produto where nome like '%$PProduto%' and idTipo like $VtJs or descricao like '%$PProduto%' and idTipo like $VtJs order by idProduto");
        $PProduto = $_GET['PProduto']; //Se houver produto digitado (Valor usado para preencher a caixa de pequisa de produto)

	if (!$queryProduto) {
	    $PProduto = $_GET['PProduto'];
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
	if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
	{
	    $PPNA = $txtPPNA;
	}
   } //Fim se a categoria não for filtrada, mas o tipo for.
   }//Fim se hover algo pesquisado 
   else if (isset($_GET['PProduto']))//Se um produto NÃO for pesquisado, mas houver filtros
   {
       $PProduto = "";
       
       if ($_GET['PProduto'] == "" && $_GET['VtJs'] == 8 && $_GET['VcJs'] == 3)//Se não houver pesquisa, nem filtros, mas houver valores neutros na URL
       {
           header('Location: painelControle.php');
       }
       
       else if (!empty($_GET['VtJs']) && $_GET['VtJs'] != "8" && !empty($_GET['VcJs']) && $_GET['VcJs'] < "3")//Filtro para VtJs e VcJs.
       {
            $VtJs = $_GET['VtJs'];//Recuperar o tipo selecionado que está na URL
            $VcJs = $_GET['VcJs']; //Recuperar a categoria selecionada que está na URL
            $queryProduto = mysqli_query($conexao, "select * from Produto where idTipo like $VtJs and idCategoria like $VcJs order by idProduto");
        
		if (!$queryProduto)
		{
            $PProduto = "";
            echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
            die('<b>Query Inválida:</b>');  
	    }
	        
		if (mysqli_num_rows($queryProduto) < 1)//Produto não encontrado
		{
		    $PPNA = $txtPPNA;
		}
       }//filtro VtJs e VcJs
       else if (!isset($_GET['VtJs']) or $_GET['VtJs'] == 8 && isset($_GET['VcJs']) && $_GET['VcJs'] <3) //Se o tipo não for filtrado, mas a categoria for.
       {
           $VtJs = 8; //Valor do select tipo se não houver pesquisa
           $VcJs = $_GET['VcJs']; //Valor do select categoria se não houver pesquisa
        $queryProduto = mysqli_query($conexao,"select * from Produto where idCategoria like $VcJs order by idProduto");
        $PProduto = ""; //Se não houver produto digitado (Valor usado para preencher a caixa de pequisa de produto)

	if (!$queryProduto) {
	    $PProduto = "";
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
	if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
	{
	    $PPNA = $txtPPNA;
	}
       }//If -empty($_GET['VtJs']) 
   // or !isset($_GET['VtJs']) && !isset($_GET['VcJs'])
   else if (!isset($_GET['VcJs']) or $_GET['VcJs'] = 3 && isset($_GET['VtJs']) && $_GET['VtJs'] < 8)//Se a categoria não for filtrada, mas o tipo for.
   {
       $VtJs = $_GET['VtJs'];
       $VcJs = 3;
        $queryProduto = mysqli_query($conexao,"select * from Produto where idTipo like $VtJs order by idProduto");
        $PProduto = ""; //Se não houver produto digitado (Valor usado para preencher a caixa de pequisa de produto)

	if (!$queryProduto) {
	    $PProduto = "";
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
	if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
	{
	    $PPNA = $txtPPNA;
	}
   } //Fim se a categoria não for filtrada, mas o tipo for.
   }//Else if - fim Se um produto NÃO for pesquisado
   
    else if (!isset($_GET['PProduto']) && !isset($_GET['VcJs']) && !isset($_GET['VtJs']))//Não há pesquisa nem filtros nem nada na URL
   {
       $VtJs = 8;
       $VcJs = 3;
        $queryProduto = mysqli_query($conexao,"select * from Produto order by idProduto");
        $PProduto = ""; //Se não houver produto digitado (Valor usado para preencher a caixa de pequisa de produto)

	if (!$queryProduto) {
	    $PProduto = "";
		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
		die('<b>Query Inválida:</b>');  
	}
	if (mysqli_num_rows($queryProduto) < 1)//Produto pesquisado não encontrado
	{
	    $PPNA = $txtPPNA;
	}
   }
	   //---------------Fim de "para criar variável $dadosProduto posteriomente"--------------- 

        if($_GET["aba"] != "pedidos" && $_GET["aba"] != "entregadores" && $_GET["aba"] != "produtos" && $_GET["aba"] != "movimentacao" && $_GET["aba"] != "relatorio") {
            $_GET["aba"] = "pedidos";
        }

        $aba = $_GET["aba"];

        ?>
       <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
                
                <script src="../styles/jquery-3.6.1.min.js"></script>
                <script src="../styles/bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
                <link href="../styles/bootstrap-5.2.2-dist/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Judson" />
                <link rel="stylesheet" type="text/css" href="../styles/header.css" />
                <meta name="viewport" content="width=device-width">
                <?php include_once('../styles/painelControle.css'); // <!--Adicionando CSS à página-->
                if(array_key_exists("notificacao", $_GET)) { ?>
                    <script type="text/javascript">
                        $(window).on('load', function() {
                            $('#notificacoesModal').modal('show');
                        });
                    </script>
                <?php } ?> <!-- Abrir menu de notificações caso uma seja adicionada ou excluída. -->
                <title>Painel de Controle</title>
            </head>
            <body>
                <center>
                <h1 class="titulo">PAINEL DE CONTROLE</h1>
                <div class='btnDiv'>
                    <button type="button" class="btn btn-primary" onclick="location.href='<?php echo "$linkBtnLogin"; ?>'">Fazer Logoff</button><!--Botão de login/logoff-->
                    <button type="button" class="btn btn-primary" onclick="location.href='<?php echo "$linkBtnCCE"; ?>'">Criar conta de entregador</button>
                    <button type="button" class="btn btn-primary" onclick="location.href='<?php echo "$linkBtnCP"; ?>'">Cadastrar novo produto</button>
                    <button type="button" class="btn btn-primary" onclick="location.href='../login/histLogin.php'">Histórico de login</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notificacoesModal">Notificações</button>
                </div>
                </center>
                <center>
                    
                    

                <div style="display: flex; justify-content: center;">
                    <div style="display: flex; flex-direction: column; width: 90%;">
                        <div style="display: flex; justify-content: center; margin-top: 19px;">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a type="button" class="nav-link <?php if($aba == "pedidos") echo "active";?>" <?php if($aba == "pedidos") echo 'aria-current="page"';?> onclick="window.location='?aba=pedidos'">Pedidos</a>
                                </li>
                                <li class="nav-item">
                                    <a type="button" class="nav-link <?php if($aba == "entregadores") echo "active";?>" <?php if($aba == "pedidos") echo 'aria-current="page"';?> onclick="window.location='?aba=entregadores'">Entregadores</a>
                                </li>
                                <li class="nav-item">
                                    <a type="button" class="nav-link <?php if($aba == "produtos") echo "active";?>" <?php if($aba == "pedidos") echo 'aria-current="page"';?> onclick="window.location='?aba=produtos'">Produtos</a>
                                </li>
                                <li class="nav-item">
                                    <a type="button" class="nav-link <?php if($aba == "movimentacao") echo "active";?>" <?php if($aba == "pedidos") echo 'aria-current="page"';?> onclick="window.location='?aba=movimentacao'">Movimentação</a>
                                </li>
                                <li class="nav-item">
                                    <a type="button" class="nav-link <?php if($aba == "relatorio") echo "active";?>" <?php if($aba == "relatorio") echo 'aria-current="page"';?> onclick="window.location='?aba=relatorio'">Relatório</a>
                                </li>
                            </ul>
                        </div>
                        <?php if($aba == "pedidos") { ?>
                            <div class="divPedidos">
                                <div class="divPedidosFixo">
                                    <h3 class="PedidosTitulo" >PEDIDOS</h3>
                                    <!--Filtrar por status:
                                    <select id="">
                                    <option value="tds" selected>Todos</option>
                                    <option value="1">Em análise</option>
                                    <option value="2">Aceitos</option>
                                    <option value="3">Recusados</option>
                                    <option value="4">Já entregues</option>
                                    </select>

                                    <button class="btn btn-outline-secondary" type="button"  onclick="window.location='painelControle.php'">Limpar filtros</button> -->
                                </div><!--divPedidoFixo-->
                                <div class="divPedidosFluido">
                                    <?php
                                    while($dadosPedido=mysqli_fetch_array($queryPedido))
                                    { 
                                        $idPedido = $dadosPedido['idPedido'];

                                        $queryItemPedido = mysqli_query($conexao, "select ip.quantidade, ip.idProduto, pr.imagemUrl, pr.preco, pr.nome FROM ItemPedido ip INNER JOIN Produto pr ON ip.idProduto = pr.idProduto where ip.idPedidoFk = '$idPedido'");

                                        $qtdItens = mysqli_num_rows($queryItemPedido);

                                        $iap = "item adiconado"; //iap = Itens adicionados plural (para deixar texto no plural caso haja mais de 1 item)

                                    if ($qtdItens > 1)
                                    {
                                        $iap = "itens adiconados"; 
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
                                    <div class="encomeda">

                                        <lable class="tituloEncomenda"><b>Pedido:</b> <?php echo $qtdItens . " " . $iap; ?></lable> 
                                        <lable class="status"><?php echo $iconePedido; ?> <b>Status:</b> <?php echo $statusPedido; ?></lable>
                                        <br>
                                            <div class="conteudoPedido">
                                                <lable class="TituloConteudo">Conteúdo:</lable>
                                                <div class="itensPedidoFluido">
                                                    <?php while($dadosItemPedido=mysqli_fetch_array($queryItemPedido)) {
                                                        $idProdutoMd5 = md5($dadosItemPedido['idProduto']);

                                                        //Capturar a primeira imagem inserida do produto

                                                        $PImagemArray =  $dadosItemPedido['imagemUrl'];//$PImagem = Primeira imagem (Array)
                                                        $urlImagem;
                                                        if (empty($PImagemArray[0]))
                                                        {
                                                            $PImagem = "semImagens.png";
                                                            $urlImagem = "imgs/";
                                                        }
                                                        else
                                                        {
                                                            $PImagemArraylinha1 = explode("\n",$PImagemArray);
                                                            $PImagem = $PImagemArraylinha1[0];
                                                            $urlImagem = "imgProdutos/";
                                                        }

                                                        //Fim de capturar a primeira imagem inserida do produto
                                                    ?>

                                                    <a href="editarProduto.php?id=<?php echo $idProdutoMd5; ?>">
                                                    <div class="itensPedido">

                                                        <center>| x<?php echo $dadosItemPedido['quantidade']; ?> <?php echo $dadosItemPedido['nome']; ?> -
                                                        R$ <?php echo number_format($dadosItemPedido['preco'],2,",","."); ?> cada|</center>
                                                    </div> <!--Item pedido-->
                                                    </a>
                                                    <?php } 
                                                    $idPedidoMd5 = md5($dadosPedido['idPedido']);
                                                    ?>

                                                </div> <!--itensPedidoFluido-->
                                            </div> <!--Conteúdo pedido-->
                                        <lable class="dataStatus"><b>Última alteração de Status:</b> <?php echo (new DateTime($dadosPedido['dataPedido']))->format('d/m/Y H:i'); ?>
                                        <br>
                                        <a class="btn btn-outline-secondary" href="../msg.php?id=<?php echo $idPedidoMd5;?>">Chat</a>
                                        <a class="btn btn-outline-secondary" href="infoPedido.php?id=<?php echo md5($dadosPedido['idPedido']); ?>">Informações do Pedido</a>
                                    </div> <!--Div encomenda-->
                                    <?php } ?>
                                </div> <!--fim div "divPedidosFluido"-->
                            </div>
                        <?php }
                        else if($aba == "entregadores") { ?>
                            <div class="divEntregadores">
                                <div class="divEntregadoresFixo">
                                    <h3 class="EntregadoresTitulo" >ENTREGADORES</h3>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" title="Pesquisar um entregador" placeholder="Pesquisar um entregador" aria-label="Recipient's username" aria-describedby="button-addon2" id="pesquisaEntregador" value=<?php echo $PEntregador; ?>>

                                        </button>
                                        <button class="btn btn-outline-secondary" type="button"  onclick="window.location='painelControle.php?aba=entregadores'">Limpar filtros</button>
                                        <button class="btn btn-outline-secondary" title="Buscar" type="button" onclick="PEntregadorJs ()"><?php include_once('../icones/search.svg');?></button>
                                    </div>
                                </div><!--divEntregadoresFixo-->
                                <div class="divEntregadoresFluido">
                                    <?php while($dadosEntregador=mysqli_fetch_array($queryEntregador)) {?> <!--Craindo a variável $dadosEntregador-->

                                    <div class="entregadorLista"><p class="entregadorNome"><?php echo $dadosEntregador['nome'] . " " . $dadosEntregador['sobrenome']; ?></p><button type="button" class="btn btn-secondary" onclick="location.href='<?php echo $linkBtnEditar . md5($dadosEntregador['idUsuario']); ?>'">Editar</button><button type="button" class="btn btn-danger" onclick="location.href='<?php echo $linkBtnExcluir . md5($dadosEntregador['idUsuario']); ?>'">Excluir</button><br>
                                        <p class="entregadorEmail"><?php echo $dadosEntregador['email']; ?></p>
                                    </div><!--Div entregador lista-->
                                    <?php } ?> <!--fim do while-->
                                    <?php echo $PENA; ?>
                                </div> <!--fim div "divEntregadoresFluido"-->
                            </div>
                        <?php }
                        else if($aba == "produtos") { ?>
                        <div class="containerProduto">
                        <h3 class="ProdutosTitulo" >PRODUTOS</h3>
                        <!--//Pesquisa Produto\\-->
                            <div class="divPesquisa">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" title="Procurar produtos" id="pesquisarProduto" placeholder="Procurar Produtos" aria-label="Example text with button addon" aria-describedby="button-addon1" value="<?php echo $PProduto;?>">
                                    <button class="btn btn-outline-secondary" type="button" title="Limpar pesquisa" id="idBtnLimpaPesquisa" onclick="lpp()"><?php include('../icones/X_lg.svg');?></button>
                                    <button class="btn btn-outline-secondary" type="button" title="Buscar" id="idBtnPesquisar" onclick="PProdutoJs()"><?php include('../icones/search.svg');?></button>
                                </div>
                            </div><!--divPesquisa-->
                            <!--//Fim pesquisa Produto\\-->

                            Tipo:
                            <select id="IdSelTipo">
                                <option value="1">Camisas</option>
                                <option value="2">Vestidos</option>
                                <option value="3">Gravatas</option>
                                <option value="4">Calças</option>
                                <option value="5">Meias</option>
                                <option value="6">Cintos</option>
                                <option value="7">Ternos</option>
                                <option value="8" selected>Todos</option>
                            </select>
                            Categoria:
                            <select id="IdSelCategoria">
                                <option value="1">Feminino</option>
                                <option value="2">Masculino</option>
                                <option value="3" selected>Todos</option>
                            </select>

                            <div class="btn-group" role="group" aria-label="Basic example">
                                <input type="button" class="btn btn-outline-secondary" value="Filtrar" onclick="PProdutoJs ()">
                                <input type="button" class="btn btn-outline-secondary" value="Limpar Filtros" onclick="limparFiltros()">
                            </div>


                            <div class="divprodutoFluido">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Imagem</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($dadosProduto=mysqli_fetch_array($queryProduto)) { 
                                //Capturar a primeira imagem inserida do produto

                                $PImagemArray =  $dadosProduto['imagemUrl'];//$PImagem = Primeira imagem (Array)
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
                                <tr>
                                    <th scope="row"></th>
                                    <td><?php echo $dadosProduto['nome']; ?></td>
                                    <td><?php echo 'R$ ' . number_format($dadosProduto['preco'],2,",","."); ?></td>
                                    <td>Em estoque: <?php echo $dadosProduto['quantidadeEstoque']; ?></td>
                                    <td><img src="<?php echo $urlImagem . $PImagem; ?>" class="img-fluid" alt="...">
                                    </td>
                                    <td>
                                    <div class="btn-group-vertical">
                                    <a class="btn btn-secondary" href="editarProduto.php?id=<?php echo md5($dadosProduto["idProduto"]);?>">Editar</a>
                                    <!--<a class="btn btn-danger" href="excluirProduto.php?id=<?php echo md5($dadosProduto["idProduto"]);?>">Excluir</a>-->
                                    <a class="btn btn-dark" href="editarEstoque.php?id=<?php echo md5($dadosProduto["idProduto"]);?>">Estoque</a>
                                    </div>

                                    </td>
                                </tr>
                            <?php } ?> <!--fim do while-->
                            </table>

                            <?php echo $PPNA; 
                            ?>

                            <!----------------------------Fim do catálogo---------------------------->


                            </div>
                        </div>
                        <?php }
                        else if($aba == "movimentacao") { ?>
                        <div style="display: flex">
                            <div class="containerProduto" style="width: 100%;">
                                <h3 class="ProdutosTitulo" >MOVIMENTAÇÃO</h3>
                                <div class="divMovimentacaoFluido">
                                    <table class="table flex">
                                        <thead>
                                            <tr>
                                                <!--<th scope="col"></th>-->
                                                <th scope="col">Produto</th>
                                                <th scope="col">Quantidade</th>
                                                <th scope="col">Observação</th>
                                                <th scope="col">Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlMovimento = "SELECT p.idProduto, p.nome, m.tipo, m.data, m.quantidade, m.observacao, m.idPedido
                                            FROM Produto p
                                            INNER JOIN Movimento m
                                            ON p.idProduto = m.idProduto
                                            ORDER BY m.data DESC;";
                                            $resultadoMovimento = mysqli_query($conexao, $sqlMovimento);

                                            while($row = mysqli_fetch_assoc($resultadoMovimento)) {
                                                if($row["tipo"]) {
                                                $operador = "+";
                                                $cor = "#9FF59D";
                                            } else {
                                                $operador = "-";
                                                $cor = "#FF857E"; 
                                            } ?>
                                            <tr>
                                                <td><a href="editarProduto.php?id=<?php echo md5($row['idProduto']); ?>"><?php echo $row["nome"];?></a></td>
                                                <td style="background: <?php echo $cor; ?>;"><?php echo $operador . $row["quantidade"];?></td>
                                                <td><?php echo $row["observacao"];?></td>
                                                <td><?php echo date_format(date_create($row["data"]), "d/m/Y (H:i:s)");?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php }
                        else if($aba == "relatorio") { ?>
                            <div style="display: flex">
                                <div class="containerProduto" style="width: 100%;">
                                    <h3 class="ProdutosTitulo" >RELATÓRIO</h3>
                                    <div class="divMovimentacaoFluido">
                                        <table class="table flex">
                                            <thead>
                                                <tr>
                                                    <!--<th scope="col"></th>-->
                                                    <th scope="col">Categoria</th>
                                                    <th scope="col">Faixa Etária</th>
                                                    <th scope="col">Cor</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Tamanho</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include("relatorioSql.php");
                                                $resultadoRelatorio = mysqli_fetch_assoc(mysqli_query($conexao, $sqlRelatorio));

                                                $categoria = $resultadoRelatorio["categoria"];
                                                $faixaEtaria = $resultadoRelatorio["faixaEtaria"];
                                                $cor = $resultadoRelatorio["cor"];
                                                $tipo = $resultadoRelatorio["tipo"];
                                                $tamanho = $resultadoRelatorio["tamanho"];
                                                switch($tamanho) {
                                                    case 1: $tamanho = "P"; break;
                                                    case 2: $tamanho = "M"; break;
                                                    case 3: $tamanho = "G"; break;
                                                    case 4: $tamanho = "GG"; break;
                                                    case 5: $tamanho = "Não especificado"; break;
                                                } ?>

                                                <tr>
                                                    <td><?php echo $categoria; ?></td>
                                                    <td><?php echo $faixaEtaria; ?></td>
                                                    <td><?php echo $cor; ?></td>
                                                    <td><?php echo $tipo; ?></td>
                                                    <td><?php echo $tamanho; ?></td>
                                                    <td><?php echo date("d/m/Y (H:i:s)"); ?></td>
                                                    <td>
                                                        <form method="post" action="BDrelatorio.php">
                                                            <input type='hidden' name='acao' id='acao' value='1'/>
                                                            <input type='hidden' name='categoria' id='categoria' value='<?php echo $categoria;?>'/>
                                                            <input type='hidden' name='faixaEtaria' id='faixaEtaria' value='<?php echo $faixaEtaria;?>'/>
                                                            <input type='hidden' name='cor' id='cor' value='<?php echo $cor;?>'/>
                                                            <input type='hidden' name='tipo' id='tipo' value='<?php echo $tipo;?>'/>
                                                            <input type='hidden' name='tamanho' id='tamanho' value='<?php echo $tamanho;?>'/>
                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <?php
                                                $sqlRelatorio = "SELECT * FROM `relatorio` ORDER BY `data_relatorio` DESC";
                                                $resultadoRelatorio = mysqli_query($conexao, $sqlRelatorio);

                                                while($row = mysqli_fetch_assoc($resultadoRelatorio)) {
                                                    $idRelatorio = $row["idRelatorio"];
                                                    $categoria = $row["categoria"];
                                                    $faixaEtaria = $row["faixaEtaria"];
                                                    $cor = $row["cor"];
                                                    $tipo = $row["tipo"];
                                                    $tamanho = $row["tamanho"]; 
                                                    $data = $row["data_relatorio"];

                                                    switch($tamanho) {
                                                        case 1: $tamanho = "P"; break;
                                                        case 2: $tamanho = "M"; break;
                                                        case 3: $tamanho = "G"; break;
                                                        case 4: $tamanho = "GG"; break;
                                                        case 5: $tamanho = "Não especificado"; break;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $categoria; ?></td>
                                                        <td><?php echo $faixaEtaria; ?></td>
                                                        <td><?php echo $cor; ?></td>
                                                        <td><?php echo $tipo; ?></td>
                                                        <td><?php echo $tamanho; ?></td>
                                                        <td><?php echo date_format(date_create($data), "d/m/Y (H:i:s)"); ?></td>
                                                        <td>
                                                            <form method="post" action="BDrelatorio.php">
                                                                <input type='hidden' name='acao' id='acao' value='0'/>
                                                                <input type='hidden' name='idRelatorio' id='idRelatorio' value='<?php echo $idRelatorio;?>'/>
                                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
                 
                 <br>
            </body>
            </html>
            
            <script language="Javascript"> //Script para busca de entregadores
            
            function PEntregadorJs () //PEntregador = Pesquisar de Entregador (javaScript)
            {
                var VPEntregadorJs = document.getElementById('pesquisaEntregador').value; //VPEntregadorJs = Variável Pesquisar de Entregador (javaScript)
                window.location = "painelControle.php?aba=entregadores&PEntregador=" + VPEntregadorJs;
            }
            
            //Ao teclar 'Enter' e a pesquisa entregador estiver focada, buscar.
            var pceEnt = document.getElementById('pesquisaEntregador'); //pceEnt = Pesquisa com enter Entregador.
            pceEnt.addEventListener('focus', function()
            {
                document.addEventListener("keypress", function(e) {
            if(e.key === 'Enter')
            {
                PEntregadorJs ();
            }//if
            });//Função keypress
            });//pceEnt (função)
            
            </script>
            <!-------------------------------------Script para busca de produtos------------------------------->
            <script language="Javascript"> //Script para busca de produtos
            
            //Completar select com valor
            var IdSelTipoJs = document.getElementById("IdSelTipo"); //IdSelTipoJs = IdSelTipo (Javascript)
            var VtJs2 = <?php echo $VtJs;?>;//php
            if (VtJs2 == "undefined")
            {
                VtJs2 = 8; //8 = Não especificado
            }
            var IdSelCategoriaJs = document.getElementById("IdSelCategoria"); //IdSelCategoriaJs = IdSelCategoria (Javascript)
            var VcJs2 = <?php echo $VcJs;?>;
            if (VcJs2 == "undefined")
            {
                VcJs2 = 3; //3 = Não especificado
            }
            
            IdSelTipoJs.value = (VtJs2);
            IdSelCategoriaJs.value = (VcJs2);
            //Fim completar select com valor
            
            function lpp() //lpp = limpar pesquisa de produto
            {
                var pesqProd = document.getElementById('pesquisarProduto'); //pesqProd  = Pesquisa de produto
                pesqProd.value = ("");
            }
            
            function PProdutoJs () //PEntregador = Pesquisar de Entregador (javaScript)
            {
                var VPProdutoJs = document.getElementById('pesquisarProduto').value; //VPProdutoJs = Variável Pesquisar de Produto (javaScript)
                var VtJs = document.getElementById('IdSelTipo').value;//VtJs = Variável filtro de tipo (javaScript)
                var VcJs = document.getElementById('IdSelCategoria').value;//VcJs = Variável filtro de Categoria (javaScript)
                window.location = "painelControle.php?aba=produtos&PProduto=" + VPProdutoJs + "&VtJs=" + VtJs + "&VcJs=" + VcJs;
            }
            function limparFiltros ()
            {
                window.location = "painelControle.php?aba=produtos";
            }
            
            //Ao teclar 'Enter' e a pesquisa produto estiver focada, buscar.
            var pce = document.getElementById('pesquisarProduto'); //pce = Pesquisa com enter.
            pce.addEventListener('focus', function()
            {
                document.addEventListener("keypress", function(e) {
            if(e.key === 'Enter')
            {
                PProdutoJs();
            }//if
            });//Função keypress
            });//pce (função)
            </script>