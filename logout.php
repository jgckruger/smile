<?php
//require_once("header.php");
require_once("db/DBClass.php");
$banco = new DBClass();
session_start();
unset ($_SESSION['login']);
unset ($_SESSION['senha']);
session_destroy();
header('location:index.php');
