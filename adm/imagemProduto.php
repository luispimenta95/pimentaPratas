<?php
session_start();
include '../BD/.conecta.php';
include '../mensagemPadrao.php';


$idObra = $_GET['id'];

$diretorio = "../Imagens/";

if (!is_dir($diretorio)) {
  echo "Pasta $diretorio nao existe";
} else {
  $arquivo = $_FILES['arquivo'];
  for ($controle = 0; $controle < count($arquivo['name']); $controle++) {

    $extensao = strtolower(substr($arquivo['name'][$controle], -4)); //pega a extensao do arquivo
    $novo_nome = "projeto_" . md5(time() + $controle) . $extensao;
    $destino = $diretorio . "/" . $novo_nome[$controle];
    $_UP['pasta'] = '../Imagens/';


    if (move_uploaded_file($_FILES['arquivo']['tmp_name'][$controle], $_UP['pasta'] . $novo_nome)) {
      $sql_code = "INSERT INTO imagens (imagem,produto,dataCadastro) VALUES('$novo_nome','$idObra',NOW())";
    }

    if ($conn->query($sql_code) === TRUE) {

      $_SESSION['msg'] = $mensagens["cadastro"];

      header("Location:produto.php");
    } else {
      $_SESSION['msg'] = $mensagens["erroCadastro"];

      header("Location:produto.php");
    }
  }
}
