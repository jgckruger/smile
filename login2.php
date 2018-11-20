<?php
//require_once("header.php");
require_once("db/DBClass.php");
$banco = new DBClass();
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$senha = $_POST['password'];

$query = "SELECT * FROM `administrador` WHERE BINARY username='".$login."' AND BINARY password='".md5($senha)."';";
$resultado = $banco->query($query);
$correto = false;
$id = 0;
if($row = $resultado->fetch_assoc()) {
  $correto = true;
  $id = $row['idAdmin'];
}
if($correto){
  $_SESSION['login'] = $login;
  $_SESSION['senha'] = $senha;
  $_SESSION['id'] = $id;
  header('location:index.php');
}else{
  unset ($_SESSION['login']);
  unset ($_SESSION['senha']);
  unset ($_SESSION['id']);
  header('location:index.php');
}


$banco->close();
require_once("../../footer.php");
 ?>
