<?php
session_start();

include 'BD/.conecta.php';
include 'adm/funcoes.php';
include 'mensagemPadrao.php';

$cpf = $_POST["cpf"];
$email = $_POST["email"];
$novaSenha = $_POST["novaSenha"];
$confirmacao = $_POST["confirmacao"];

echo $email . "<br>" . $cpf . "<br>" . $novaSenha . "<br>"  . $confirmacao . "<br>";


$pesquisaUsuarios = "SELECT cpf_cnpj,emailCliente from cliente u  where u.cpf_cnpj= $cpf";
$result = $conn->query($pesquisaUsuarios);
$rowcount = mysqli_num_rows($result);

if ($rowcount == 0) {
    $_SESSION['msg'] = $mensagens["cpfNaoEncontrado"];
    header("Location:esqueciSenha.php");
} else {
    $acesso = $result->fetch_assoc();
    if ($email != $acesso['emailCliente']) {
        $_SESSION['msg'] = $mensagens["erroEmailDivergergente"];
        header("Location:esqueciSenha.php");
    } else if ($novaSenha != $confirmacao) {
        $_SESSION['msg'] = $mensagens["erroConfirmacao"];
        header("Location:esqueciSenha.php");
    } else {
        $sqlUpdate = "UPDATE cliente SET senhaCliente = '$novaSenha' WHERE cpf_cnpj = '$cpf'";


        if ($conn->query($sqlUpdate) === TRUE) {
            $_SESSION["esqueciSenha"] = 0;

            $_SESSION['msg'] = $mensagens["atualizarEsqueceuSenha"];
            header("Location:loginCliente.php");
        } else {

            $_SESSION['msg'] = $mensagens["erroAtualizarSenhaHost"];
            header("Location:loginCliente.php");
        }
    }
}
