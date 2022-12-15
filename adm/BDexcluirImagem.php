<?php

include_once('Vadm.php');

function deleteImagem($conexao, $imagemR, $id) {
    $sqlProduto = "SELECT * FROM `Produto` WHERE md5(`idProduto`) = '$id'";
    $resultadoProduto = mysqli_fetch_assoc(mysqli_query($conexao, $sqlProduto));

    if($resultadoProduto["imagemUrl"] == "") return "<script>window.location='editarProduto.php?id=" . $id . "'</script>";

    $imagens = explode("\n", $resultadoProduto["imagemUrl"]);

    if (($key = array_search($imagemR, $imagens)) !== false) {
        unset($imagens[$key]);
        unlink("../imgProdutos/$imagemR");
    }

    $imagem = implode("\n", $imagens);

    $sqlImagem = "UPDATE `Produto` SET `imagemUrl` = '$imagem' WHERE md5(`idProduto`) = '$id'";
    if(mysqli_query($conexao, $sqlImagem)) return "<script>window.location='editarImagem.php?id=" . $id . "'</script>";
    else return '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br><b>Query Inválida:</b>' . @mysqli_error($conexao);
}

if(array_key_exists('imagem', $_POST)) {
    echo deleteImagem($conexao, $_POST["imagem"], $_POST["id"]);
}
?>
