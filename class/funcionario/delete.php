<?php
//including the database connection file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../../db/DBClass.php");
$banco = new DBClass();

//getting id of the data from url
$id = $_GET['id'];


//deleting the row from table
$result = $banco->query("DELETE FROM funcionario WHERE idFuncionario=$id");

//redirecting to the display page (index.php in our case)
header("Location:index.php");
?>
