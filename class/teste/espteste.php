<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
var_dump($_GET);
echo '<br><br><br><br>';


$t = time();
$ts = date('Y-m-d-H-i-s', $t);
$in = $_GET['camera_entrada'];
$out = $_GET['camera_saida'];
$STRcmdIN = 'python /var/www/pics/camera.py '.$in.' '.$ts.'-in.jpg';
$STRcmdOUT = 'python /var/www/pics/camera.py '.$out.' '.$ts.'-out.jpg';
$cmdIN = escapeshellcmd($STRcmdIN);
$cmdOUT = escapeshellcmd($STRcmdOUT);
$output1 = shell_exec($cmdIN);
$output2 = shell_exec($cmdOUT);

?>
