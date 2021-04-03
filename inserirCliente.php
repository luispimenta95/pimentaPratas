<?php
session_start();
require 'mailer/PHPMailerAutoload.php';

include 'BD/.conecta.php';
include 'adm/funcoes.php';
include 'mensagemPadrao.php';

$nomeCliente = $_POST["nome"];
$cpf = $_POST["cpf"];
$email = $_POST['email'];
$telefone = $_POST["telefone"];
$endereco = $_POST["endereco"];
$tipoCliente = $_POST["tipoCliente"];
$cidade = $_POST["cidade"];
$senha = substr(time(), 4, 7);
$pesquisaUsuarios = "SELECT cpf_cnpj from cliente u  where u.cpf_cnpj= $cpf";
$Usuarios = mysqli_query($conn, $pesquisaUsuarios);
if (!validaCPF($cpf)) {

    $_SESSION['msg'] = $mensagens["cpfInvalido"];
    header("Location:loginCliente.php");
} else {

    //Contar o total de logs
    $totalUsuarios = mysqli_num_rows($Usuarios);
    if ($totalUsuarios > 0) {
        $_SESSION['msg'] = $mensagens["cpfDuplicado"];
        header("Location:loginCliente.php");
    } else {

        $sqlInsert = "INSERT INTO  cliente (nomeCliente,cpf_cnpj,emailCliente,telefoneCliente,enderecoCliente,senhaCliente,tipoCliente,cidade,dataCadastro)
        VALUES ('$nomeCliente', '$cpf', '$email', '$telefone', '$endereco', '$senha',$tipoCliente,$cidade,NOW())";

        $mail = new PHPMailer;
        //Para funcionar o email não pode ter verificação em 2 etapas
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();        // Ativar SMTP
        $mail->SMTPDebug = false;       // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
        $mail->SMTPAuth = true;     // Autenticação ativada
        $mail->SMTPSecure = 'ssl';  // SSL REQUERIDO pelo GMail
        $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
        $mail->Port = 465;
        $mail->Username = 'luisfelipearaujopimenta@gmail.com';
        $mail->Password = 'Mpl13151319';
        $mail->SetFrom('luisfelipearaujopimenta@gmail.com');
        $mail->addAddress('luisfelipearaujopimenta@gmail.com');
        $mail->Subject = ("Definição de senha ");
        $mail->msgHTML("Sua nova senha é : " . $senha);

        if ($conn->query($sqlInsert) === TRUE /*&& $mail->send() */) {
            $_SESSION['msg'] = $mensagens["cadastroHost"];
            header("Location:loginCliente.php");
        } else {

            $_SESSION['msg'] = $mensagens["erroCadastro"];
            header("Location:loginCliente.php");
        }
    }
}
