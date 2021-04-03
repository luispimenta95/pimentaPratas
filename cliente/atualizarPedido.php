<?php
session_start();
include('../BD/.conecta.php');
include('../mensagemPadrao.php');

$idPedido = $_GET['id'];
$quantidade = $_POST['contador'];

$sqlUpdate = "UPDATE pedido SET quantidade = $quantidade WHERE idpedido = $idPedido";


if ($conn->query($sqlUpdate) === TRUE) {
    $_SESSION['msg'] = $mensagens["atualizarPedido"];
    header("Location:carrinho.php");
} else {

    $_SESSION['msg'] = $mensagens["erroAtualizarPedido"];
    header("Location:carrinho.php");
}
