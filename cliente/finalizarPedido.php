<?php
session_start();
include('../BD/.conecta.php');
include('../mensagemPadrao.php');


$sqlUpdate = "UPDATE pedido SET pedidoFinalizado = 1 WHERE codPedido = '$_SESSION[codPedido]'";

if ($conn->query($sqlUpdate) === TRUE) {
    $_SESSION['msg'] = $mensagens["finalizarPedido"];
    unset($_SESSION['codPedido']);

    header("Location:home.php");
} else {

    $_SESSION['msg'] = $mensagens["erroFinalizarPedido"];
    header("Location:home.php");
}
