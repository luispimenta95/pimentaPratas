<?php
session_start();

include '../BD/.conecta.php';
include '../adm/funcoes.php';
include '../mensagemPadrao.php';

$cpf = $_POST["cpf"];
$senhaP = $_POST["senhaP"];
$novaSenha = $_POST["novaSenha"];
$confirmacao = $_POST["confirmacao"];
$pesquisaUsuarios = "SELECT cpf_cnpj,senhaCliente from cliente u  where u.cpf_cnpj= $cpf";
$result = $conn->query($pesquisaUsuarios);
$rowcount = mysqli_num_rows($result);

if ($rowcount == 0) {
    $_SESSION['msg'] = $mensagens["cpfNaoEncontrado"];
    header("Location:primeiroAcesso.php");
} else {
    $acesso = $result->fetch_assoc();
    if ($senhaP != $acesso['senhaCliente']) {
        $_SESSION['msg'] = $mensagens["erroSenhaProvisoria"];
        header("Location:primeiroAcesso.php");
    } else if ($novaSenha != $confirmacao) {
        $_SESSION['msg'] = $mensagens["erroConfirmacao"];
        header("Location:primeiroAcesso.php");
    } else {
        $sqlUpdate = "UPDATE cliente SET senhaCliente = '$novaSenha', primeiroAcesso = 0 WHERE cpf_cnpj = '$cpf'";


        if ($conn->query($sqlUpdate) === TRUE) {
            $_SESSION["primeiroAcesso"] = 0;

            $_SESSION['msg'] = $mensagens["atualizarSenhaHost"];
            header("Location:home.php");
        } else {

            $_SESSION['msg'] = $mensagens["erroAtualizarSenhaHost"];
            header("Location:primeiroAcesso.php");
        }
    }
}
