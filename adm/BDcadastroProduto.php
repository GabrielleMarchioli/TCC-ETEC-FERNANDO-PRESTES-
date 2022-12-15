<?php

/*
Erros que podem ser retornados dessa página para a página cadastroPoduto.php:

Erro 1 - Quando o formato do arquivo que está sendo enviado não é suportado.
-------------------------------------------------------------------------------------------
Mensagens que podem ser retornadas dessa página para a página painelControle.php:
msg 1 - Quando o produto é cadastrado com sucesso.

*/

include_once('../conexao.php');
include_once('Vadm.php'); //Arquivo para verificar se é um entregador que está logado

$nomeProduto = $_POST['nomeProduto'];
$descricaoProduto = $_POST['descricaoProduto'];
$precoProduto = $_POST['precoProduto'];
$categoriaProduto = $_POST['categoriaProduto'];
$quantidadeEstoque = $_POST['quantidadeEstoque'];
$faixaEtaria = $_POST['faixaEtaria'];
$corProduto = $_POST['corProduto'];
$TipoProduto = $_POST['TipoProduto'];
$tamanhoProduto = $_POST['tamanhoProduto'];
$imagens = $_FILES['imagens'];

//Inserir dados na tabela

$sqlinsert =  "insert into Produto (nome, descricao, preco, idCategoria, quantidadeEstoque, faixaEtaria, idCor, idTipo, tamanho) values ('$nomeProduto', '$descricaoProduto', '$precoProduto', '$categoriaProduto', '$quantidadeEstoque', '$faixaEtaria', '$corProduto', '$TipoProduto', '$tamanhoProduto')";

$resultado = @mysqli_query($conexao, $sqlinsert);
if (!$resultado) {
echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar ao início"><br><br>';
die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . @mysqli_error($conexao)); 
}
else
{
    $ultimoidProduto = mysqli_insert_id($conexao);
    //echo 'Produto cadastrado com sucesso!';
}

//A conexão não é fechada aqui como de costume, pois a inserção da(s) imagem(s) ainda prescisa ser feita no banco.

//Fim inserir dados na tabela


//Imagem

$extensoespermitidas = ['jpg', 'jpeg', 'png'];
$NomeImagem = $imagens['name'];

 //--Verificar se há imagens--\\
    $haImagens = 1; //haImagens = Há imagens (1 = Há imagens)
    if($NomeImagem[0] == "")
    {
        $haImagens = 0; //(0 = Não há imagens)
    }
     //--Fim do verificar se há imagens--\\

for($i = 0; $i < count($NomeImagem); $i++)
{
    
     $NomeImagem[$i] = rand() . '-' . $NomeImagem[$i]; //Adicionar número aleatório ao nome da imagem
    
    $NomeImagemString = implode("\n",$NomeImagem);
    
    //Verificar se há imagens

    if ($haImagens == 1)//Se houver imagens
    {
    $extensao = explode('.', $NomeImagem[$i]);
    $extensao = end($extensao);
    
    if (!in_array($extensao,$extensoespermitidas)) //verificar se a extensão do arquivo é permitida pelo sistema
    {
            //Excluindo registro último registro da banco pois a extenção não é permitida
        $sqldelete =  "delete from  Produto where idProduto = '$ultimoidProduto'";
        
        	$resultado = @mysqli_query($conexao, $sqldelete);
        	if (!$resultado)
        	{
        		echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
        		die('<b>ocorreu um erro inesperado - Query Inválida:</b>' . @mysqli_error($conexao));
            }
            else
            {
                //---Alterar o AUTO_INCREMENT---\\
                $sqlupdate =  "ALTER TABLE `Produto` AUTO_INCREMENT = 1";
    
        $resultado = @mysqli_query($conexao, $sqlupdate);
        if (!$resultado)
        {
        echo '<br><input type="button" onclick="window.location='."'../index.php'".';" value="Voltar"><br><br>';
        die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>'); 
        }
                //---Fim do alterar o AUTO_INCREMENT---\\
        		die(header('Location: cadastroPoduto.php?erro=1'));
            }//fim do else
        }//fim do if
        
                //Fim do excluindo registro último registro da banco pois a extenção não é permitida\\
                
        else//Se a extenção for permitida então fazer o upload dos arquivos
        {
            $mover = move_uploaded_file($imagens['tmp_name'][$i], '../imgProdutos/' . $NomeImagem[$i]);

                $NomeImagemString = implode(",", $NomeImagem);
                $NomeImagemString = str_replace(",", "\n", $NomeImagemString);
                //die ('$NomeImagemString = ' . $NomeImagemString);

                $sqlupdate =  "update Produto set imagemUrl='$NomeImagemString' where idProduto=$ultimoidProduto";
                
                // executando instrução SQL
                $resultado = @mysqli_query($conexao, $sqlupdate);
                if (!$resultado)
                {
                    echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
                    die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
                }
            
        }
    } //fim do if (Se houver imagens)
}//fim do for

	mysqli_close($conexao);
	//Fim imagem
	$linkBtnPC = "'painelControle.php?aba=produtos'"; //$linkBtnPC = Link do botão de voltar ao paínel de controle.
	
	header('Location: mensagens/pcs.php');
?>

<html>
    <head>
        <title>Cadastro de Produto</title>
    </head>
</html>