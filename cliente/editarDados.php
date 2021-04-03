<?php
session_start();
$idCliente = $_POST["idCliente"];
include '../BD/.conecta.php';
include '../adm/funcoes.php';
include '../mensagemPadrao.php';
$pesquisaUsuarios = "SELECT * from cliente u  where u.idCliente = $idCliente";
$result = $conn->query($pesquisaUsuarios);
$user = $result->fetch_assoc();
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
    <link rel="shortcut icon" href="../imagens/icon.jpg" type="image/x-icon" />
</head>

<body>
    <div class="container">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="atualizarDados.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Nome</label>
                    <input type="text" name="nome" class="form-control" id="inputEmail4" value="<?php echo $user["nomeCliente"] ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">CPF</label>
                    <input type="text" name="cpf" class="form-control" id="inputPassword4" value="<?php echo $user["cpf_cnpj"] ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" value="<?php echo $user["emailCliente"] ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="inputPassword4" value="<?php echo $user["telefoneCliente"] ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Cidade</label>

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
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Endereço</label>
                    <input type="text" name="endereco" class="form-control" id="inputEmail4" value="<?php echo $user["enderecoCliente"] ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Senha</label>
                    <input type="password" name="senha" class="form-control" id="inputPassword4">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Deixe em branco para manter sua senha atual.
                    </small>
                </div>
            </div>


            <a onclick="return confirm('Deseja realmente alterar seus dados ?');"> <button type="submit" class="btn btn-primary">Alterar dados </button>
            </a>
            <a href="home.php">
                <button type="button" class="btn btn-default">Voltar </button>
            </a>
        </form>
    </div>
    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>