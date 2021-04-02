<?php
include(".configuracao.php");

$url = strtolower(preg_replace('/[^a-zA-Z]/', '', $_SERVER['SERVER_PROTOCOL'])) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$urls = explode("/", $url);
if (in_array("localhost", $urls)) {
   $conn = new MySQLi($conexao["servidor"], $conexao["usuarioLocal"],  $conexao["senhaLocal"], $conexao["bancoLocal"]);
} else {
   $conn = new MySQLi($conexao["servidor"], $conexao["usuarioRemoto"],  $conexao["senhaRemoto"], $conexao["bancoRemoto"]);
}
