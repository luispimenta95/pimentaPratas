<?php
session_start();
include '../BD/.conecta.php';
include "../mensagemPadrao.php";

$idImagem = $_GET["id"];
$idProduto = $_GET["idProduto"];
$sql_inicial = "UPDATE imagens ie  set capa = 0 WHERE ie.produto=$idProduto";

if ($conn->query($sql_inicial) === TRUE) {

  $sql_final = "UPDATE imagens ie  set capa = 1 WHERE ie.idImagem=$idImagem";


  if ($conn->query($sql_final) === TRUE) {

    $_SESSION['msg'] = $mensagens["definirCapa"];

    header("Location:produto.php");
  } else {
    $_SESSION['msg'] = $mensagens["erroCadastro"];

    header("Location:produto.php");
  }
}
