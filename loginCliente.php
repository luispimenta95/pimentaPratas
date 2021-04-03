<?php
session_start();
include("mensagemPadrao.php");
include("BD/.conecta.php");

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
	<title>Legrano Orgânicos</title>
	<link rel="shortcut icon" href="imagens/icon.jpg" type="image/x-icon" />
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="form-signin">
			<h2 class="text-center">Área do Cliente</h2>
			<?php
			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}

			?>
			<form method="POST" action="validaCliente.php">
				<div class="d-flex justify-content-center links">

					<!--<label>Usuário</label>-->
					<input type="text" name="usuario" placeholder="Digite o seu usuário" class="form-control"><br>

					<!--<label>Senha</label>-->
					<input type="password" name="senha" placeholder="Digite a sua senha" class="form-control"><br>

					<select name="tipoCliente" required>
						<option>Selecione</option>
						<?php

						$sql2 = "SELECT * from  tipoCliente order by nomeTipoCliente";
						$result2 = $conn->query($sql2);

						while ($socio2 = $result2->fetch_assoc()) {

						?>
							<option value="<?php echo $socio2["idTipoCliente"]; ?>"><?php echo $socio2["nomeTipoCliente"]; ?></option>
						<?php
						}
						?>
					</select>

					<input type="submit" name="btnLogin" value="Acessar" class="btn btn-default btn-block">

				</div>
				<div class="d-flex justify-content-center links">
					Não possui uma conta ?<a href="#cadastro" data-toggle="modal">Cadastre-se agora</a>
				</div>
				<div class="d-flex justify-content-center links">
					Esqueceu a sua senha ?<a href="esqueciSenha.php"> Clique aqui </a>
				</div>
			</form>

			<form action="inserirCliente.php" method="POST" class="form-group" enctype="multipart/form-data">

				<div id="cadastro" class="modal fade" role="dialog" class="form-group">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<?php
								if (isset($_SESSION['msg'])) {
									echo $_SESSION['msg'];
									unset(
										$_SESSION['msg']

									);
								}
								?>
								<h4 class="modal-title">Cadastre-se como cliente da coorporativa</h4>
							</div>
							<div class="modal-body">

								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nome" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">CPF/CNPJ: </label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cpf" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" name="email" required>
									</div>
								</div>



								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Endereço</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="endereco">
									</div>
								</div>

								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Telefone</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="telefone" required>
									</div>
								</div>

								<div class="form-group row" required>
									<label for="inputEmail3" class="col-sm-6 col-form-label">Tipo de cliente</label>
									<div class="col-sm-6">
										<select name="tipoCliente" required>
											<option>Selecione</option>
											<?php

											$sql2 = "SELECT * from  tipoCliente order by nomeTipoCliente";
											$result2 = $conn->query($sql2);

											while ($socio2 = $result2->fetch_assoc()) {

											?>
												<option value="<?php echo $socio2["idTipoCliente"]; ?>"><?php echo $socio2["nomeTipoCliente"]; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group row" required>
									<label for="inputEmail3" class="col-sm-6 col-form-label">Cidade</label>
									<div class="col-sm-6">
										<select name="cidade" required>
											<option>Selecione</option>
											<?php

											$sql3 = "SELECT * from  cidade where entrega =1 order by nomeCidade";
											$result3 = $conn->query($sql3);

											while ($cidade = $result3->fetch_assoc()) {

											?>
												<option value="<?php echo $cidade["idCidade"]; ?>"><?php echo $cidade["nomeCidade"]; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<button type="submit" class=" btn btn-primary">Cadastrar-se</button>

								<button type="submit" class=" btn btn-danger" data-dismiss="modal">Cancelar</button>
							</div>
						</div>

					</div>
				</div>

			</form>

		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>