<?php
session_start();
include '../BD/.conecta.php';
include '../mensagemPadrao.php';

$idProduto = $_GET["id"];
$nomeProduto = $_POST["nome"];
$precoAtacado = $_POST["precoAtacado"];
$precoDelivery = $_POST["precoDelivery"];
$estoque = $_POST["quantidade"];
$codigo = $_POST["codigo"];
$variacao = $_POST["variacao"];
$situacao = $_POST["situacao"];

$precoAtacado = str_replace(",", ".", $precoAtacado);
$precoAtacado = str_replace("R$", "", $precoAtacado);
$precoDelivery = str_replace(",", ".", $precoDelivery);
$precoDelivery = str_replace("R$", "", $precoDelivery);
$logoProduto;

if (isset($_FILES['arquivo'])) {
    $nome = $_FILES['arquivo']['name'];
    $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); //pega a extensao do arquivo
    $novo_nome =  md5(time()) . $extensao; //define o nome do arquivo
    $diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo
    $_UP['pasta'] = 'Imagens_produto/';



    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $novo_nome)) {
        $logoProduto = $novo_nome;
        $sqlUpdate = "UPDATE produto SET nomeProduto = '$nomeProduto', precoAtacado = '$precoAtacado' , precoDelivery = '$precoDelivery',estoque = '$estoque',
            codigo = '$codigo', unidade = '$variacao', ativo = '$situacao', imagem = '$logoProduto' 
          where idProduto=$idProduto";
    } else {
        $sqlUpdate = "UPDATE produto SET nomeProduto = '$nomeProduto', precoAtacado = '$precoAtacado' , precoDelivery = '$precoDelivery' , estoque = '$estoque',
        codigo = '$codigo', unidade = '$variacao', ativo = '$situacao' 
      where idProduto=$idProduto";
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        $_SESSION['msg'] = $mensagens["edicao"];

        header("Location:produto.php");
    } else {
        echo $sqlUpdate;

        // $_SESSION['msg'] = $mensagens["erroEdicao"];
        //header("Location:produto.php");
    }
}
