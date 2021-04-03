<?php
session_start();
include('../BD/.conecta.php');
include('../mensagemPadrao.php');

$idProduto = $_GET['id'];
$quantidade = $_POST['contador'];
$idCliente = $_SESSION['idCliente'];
$codPedido = $_SESSION['codPedido'];
$buscar = "SELECT * FROM produto WHERE idProduto = $idProduto";
$result = $conn->query($buscar);
$produto = $result->fetch_assoc();
if ($_SESSION["tipoCliente"] == 1) {
    $total =  $produto["precoAtacado"] * $quantidade;
    $preco =  $produto["precoAtacado"];
} else {
    $total =  $produto["precoDelivery"] * $quantidade;
    $preco =  $produto["precoDelivery"];
}
$sql3 = "SELECT precoFrete,nomeCidade FROM cidade ci INNER JOIN cliente cl on cl.cidade = ci.idCidade where cl.idCliente = $idCliente";
$result3 = $conn->query($sql3);
$cidade = $result3->fetch_assoc();
$frete = $cidade["precoFrete"];
$sqlInsert =
    "INSERT INTO  pedido(dataPedido, quantidade, preco, codPedido, cliente, produto,precoFrete)
VALUES (NOW(), '$quantidade', '$preco', '$codPedido', '$idCliente','$idProduto' , '$frete')";


if ($conn->query($sqlInsert) === TRUE) {
    $_SESSION['msg'] = $mensagens["envioPedido"];
    header("Location:home.php");
} else {

    $_SESSION['msg'] = $mensagens["erroPedido"];
    header("Location:home.php");
}
