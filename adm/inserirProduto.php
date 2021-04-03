<?php
session_start();
include '../BD/.conecta.php';
include '../mensagemPadrao.php';


$nomeProduto = $_POST["nome"];
$precoAtacado = $_POST["precoAtacado"];
$precoDelivery = $_POST["precoDelivery"];
$codigo = $_POST["codigo"];
$estoque = $_POST["quantidade"];
$variacao = $_POST["variacao"];
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
        $sqlInsert = "INSERT INTO produto (nomeProduto,precoAtacado,precoDelivery,codigo,estoque,unidade,imagem,dataCadastro)
        VALUES ('$nomeProduto','$precoAtacado','$precoDelivery','$codigo','$estoque','$variacao','$logoProduto',NOW())";
    }

    if ($conn->query($sqlInsert) === TRUE) {
        $_SESSION['msg'] = $mensagens["cadastro"];

        header("Location:produto.php");
    } else         $_SESSION['msg'] = $mensagens["erroCadastro"];
}
