<?php
session_start();
include 'BD/.conecta.php';
include 'mensagemPadrao.php';

$usuario = $_POST["usuario"];
$senha = $_POST["senha"];



$sql = "SELECT nomeAdministrador,idAdministrador FROM administrador WHERE LPAD(cpfAdministrador,11,'0') = '$usuario' and senhaAdministrador = '$senha'";
$result = $conn->query($sql);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) {
	$acesso = $result->fetch_assoc();
	$_SESSION['nomeAdministrador'] = $acesso["nomeAdministrador"];
	$_SESSION['idAdministrador'] = $acesso["idAdministrador"];

	$_SESSION["logado"] = true;
	$_SESSION["senha"] = $senha;


	header("Location:adm/home.php");
} else {
	$_SESSION['msg'] = $mensagens["loginIncorreto"];

	header("Location:login.php");
}
