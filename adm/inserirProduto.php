<?php
session_start();
include '../BD/.conecta.php';
include '../mensagemPadrao.php';


$nomeProduto = $_POST["nome"];
$preco = $_POST["preco"];

$estoque = $_POST["quantidade"];
$variacao = $_POST["variacao"];
$categoria = $_POST["categoria"];
$preco = str_replace(",", ".", $preco);
$preco = str_replace("R$", "", $preco);

$sqlInsert = "INSERT INTO produto (nomeProduto,precoProduto,estoque,variacao,categoriaProduto,dataCadastro)
        VALUES ('$nomeProduto','$preco','$estoque','$variacao','$categoria',NOW())";

if ($conn->query($sqlInsert) === TRUE) {
    $idProduto = $conn->insert_id;
    $nome = $_FILES['arquivo']['name'];
    $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); //pega a extensao do arquivo
    $novo_nome =  "pratas_" . md5(time()) . $extensao; //define o nome do arquivo
    $diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo
    $_UP['pasta'] = '../Imagens/';
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $novo_nome)) {

        $sqlImagens = "INSERT INTO imagens (produto,imagem,capa) VALUES ('$idProduto','$novo_nome',1)";

        if ($conn->query($sqlImagens) === TRUE) {
            $_SESSION['msg'] = $mensagens["cadastro"];

            header("Location:produto.php");
        } else {
            $_SESSION['msg'] = $mensagens["erroCadastro"];

            header("Location:produto.php");
        }
    } else {
        $_SESSION['msg'] = $mensagens["erroCadastro"];

        header("Location:produto.php");
    }
}
