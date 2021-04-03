<?php
session_start();
include '../BD/.conecta.php';
include "../mensagemPadrao.php";

$idImagem = $_GET["idImagem"];
$sql_final = "DELETE FROM imagens WHERE idImagem=$idImagem";


if ($conn->query($sql_final) === TRUE) {

    $_SESSION['msg'] = $mensagens["exclusao"];

    header("Location:produto.php");
} else {

    $_SESSION['msg'] = $mensagens["erroExclusao"];

    header("Location:produto.php");
}
