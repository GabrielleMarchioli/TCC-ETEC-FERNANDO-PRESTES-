<?php
include_once('Vadm.php'); //Arquivo para verificar se é um adm que está logado

$id = $_POST["id"];
$imagens = $_FILES['imagens'];

$extensoespermitidas = ['jpg', 'jpeg', 'png'];
$NomeImagem = $imagens['name'];

//--Verificar se há imagens--\\
$haImagens = 1; //haImagens = Há imagens (1 = Há imagens)
if ($NomeImagem[0] == "") {
    $haImagens = 0; //(0 = Não há imagens)
}
//--Fim do verificar se há imagens--\\

for ($i = 0; $i < count($NomeImagem); $i++) {
    $NomeImagem[$i] = rand() . '-' . $NomeImagem[$i]; //Adicionar número aleatório ao nome da imagem

    $NomeImagemString = implode("\n", $NomeImagem);

    //Verificar se há imagens

    if ($haImagens == 1) {
        //Se houver imagens
        $extensao = explode('.', $NomeImagem[$i]);
        $extensao = end($extensao);

        if (!in_array($extensao, $extensoespermitidas)) {
            //die(header('Location: editarImagem.php?erro=1'));
            die("<script>window.location='editarImagem.php?erro=1&id=" . $id . "'</script>");
        }

        //fim do if
        //Fim do excluindo registro último registro da banco pois a extenção não é permitida\\
        //Se a extenção for permitida então fazer o upload dos arquivos
        else {
            $mover = move_uploaded_file($imagens['tmp_name'][$i], '../imgProdutos/' . $NomeImagem[$i]);
        }
    } //fim do if (Se houver imagens)
} //fim do for

//echo '$ultimoidProduto: ' . $ultimoidProduto;
if ($haImagens == 1) {
    $sqlProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$id'";
    $resultadoProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlProduto));

    $imagemUrl = $resultadoProduto["imagemUrl"];
    
    if($imagemUrl != "") $imagemUrl = $imagemUrl . "\n" . $NomeImagemString;
    else $imagemUrl = $imagemUrl . $NomeImagemString;

    $sqlupdate = "UPDATE Produto set imagemUrl = '$imagemUrl' WHERE md5(`idProduto`) = '$id'";

    $resultado = @mysqli_query($conexao, $sqlupdate);

    if (!$resultado) {
        echo '<input type="button" onclick="window.location=' . "'index.php'" . ';" value="Voltar"><br><br>';
        die('<style> .erro { background-color: red; color: #ffffff;}</style><div class="erro"><b>Query Inválida:</b><br>Ocorreu um erro inesperado.</div><br>' . @mysqli_error($conexao));
    } else {
        echo "<script>window.location='editarImagem.php?id=" . $id . "'</script>";
    }
} else {
    echo "<script>window.location='editarImagem.php?id=" . $id . "'</script>";
}
mysqli_close($conexao);
//Fim imagem

?>
