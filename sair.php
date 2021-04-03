<?php
session_start();
include("mensagemPadrao.php");
unset($_SESSION['idAdministrador'], $_SESSION['nomeAdministrador'], $_SESSION['logado'], $_SESSION['senha']);
$_SESSION["msg"] = $mensagens["logout"];
header("Location: login.php");
