<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//var_dump($_GET);
$tipo = $_GET['tipo'];


// echo($teste);

require_once('../../db/DBClass.php');
$banco = new DBClass();

$t = time();
$ts = date('Y-m-d-H-i-s', $t);
$in = $_GET['camera_entrada'];
$out = $_GET['camera_saida'];
$STRcmdIN = 'python /var/www/html/smile/pics/camera.py '.$in.' '.$ts.'-in.jpg';
$STRcmdOUT = 'python /var/www/html/smile/pics/camera.py '.$out.' '.$ts.'-out.jpg';
$cmdIN = escapeshellcmd($STRcmdIN);
$cmdOUT = escapeshellcmd($STRcmdOUT);
$output1 = shell_exec($cmdIN);
$output2 = shell_exec($cmdOUT);

$queryNova1= "INSERT INTO `passagem`(`tipoPassagem`,`fotoIN`, `fotoOUT`) VALUES (" . $tipo . ",'/smile/pics/".$ts."-in.jpg','/smile/pics/".$ts."-out.jpg')";

//echo($queryNova1);

$resultado = $banco->query($queryNova1);

$banco->close();
?>
