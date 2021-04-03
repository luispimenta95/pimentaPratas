<?php
session_start();
include("mensagemPadrao.php");
unset($_SESSION['idCliente'], $_SESSION['nomeCliente'], $_SESSION['logado'], $_SESSION['senha']);
$_SESSION["msg"] = $mensagens["logout"];
header("Location: loginCliente.php");
