<?php
session_start();
include('../BD/.conecta.php');
include('../mensagemPadrao.php');

$idPedido = $_GET['id'];

$sqlDelete = "DELETE from pedido where idPedido  = $idPedido";


if ($conn->query($sqlDelete) === TRUE) {
    $_SESSION['msg'] = $mensagens["removerPedido"];
    header("Location:carrinho.php");
} else {

    $_SESSION['msg'] = $mensagens["erroRemoverPedido"];
    header("Location:carrinho.php");
}
