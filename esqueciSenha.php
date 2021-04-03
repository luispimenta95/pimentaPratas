<?php
session_start();
include 'BD/.conecta.php';
include 'mensagemPadrao.php';


if (!isset($_SESSION["idCliente"])) {
	header("Location:loginCliente.php");
}
mysqli_set_charset($conn, 'utf8');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<!-- Meta tags Obrigatórias -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Legrano Orgânicos</title>
	<link rel="shortcut icon" href="imagens/icon.jpg" type="image/x-icon" />
</head>

<body>
	<div class="container">
		<?php
		if (isset($_SESSION['msg'])) {
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="esqueceuSenha.php">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputEmail4">CPF</label>
					<input type="text" name="cpf" class="form-control" id="inputEmail4" placeholder="Informe o seu CPF" required>
				</div>
				<div class="form-group col-md-6">
					<label for="inputPassword4">Email</label>
					<input type="email" name="email" class="form-control" id="inputPassword4" placeholder="Informe seu Email" required>
				</div>
				<div class="form-group col-md-6">
					<label for="inputEmail4">Nova senha</label>
					<input type="password" name="novaSenha" class="form-control" id="inputEmail4" placeholder="Nova senha" required>
				</div>
				<div class="form-group col-md-6">
					<label for="inputPassword4">Confirme a nova senha</label>
					<input type="password" name="confirmacao" class="form-control" id="inputPassword4" placeholder="Confirme a nova senha" required>
				</div>
			</div>
			<a href="loginCliente.php"> <button type="button" class="btn btn-default">Voltar</button></a>
			<button type="submit" class="btn btn-primary">Atualizar senha</button>

		</form>
	</div>
	<!-- JavaScript (Opcional) -->
	<!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>