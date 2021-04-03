<?php
session_start();
include("mensagemPadrao.php");
if (isset($_SESSION["idAdministrador"])) {
	header("Location:adm/home.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pimenta pratas</title>
	<link rel="shortcut icon" href="imagens/icon.jpg" type="image/x-icon" />
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="bootstrap/css/signin.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="form-signin">
			<h2 class="text-center">Área Administrativa</h2>
			<?php
			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}

			?>
			<form method="POST" action="validaAdm.php">
				<!--<label>Usuário</label>-->
				<input type="text" name="usuario" placeholder="Digite o seu usuário" class="form-control"><br>

				<!--<label>Senha</label>-->
				<input type="password" name="senha" placeholder="Digite a sua senha" class="form-control"><br>

				<input type="submit" name="btnLogin" value="Acessar" class="btn btn-default">




			</form>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>