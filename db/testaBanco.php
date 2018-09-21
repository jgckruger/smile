<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('DBClass.php');
$banco = new DBClass();
$resultado = $banco->query("SELECT * FROM teste WHERE 1");
$banco->close();
while ($row = $resultado->fetch_assoc()) {
    echo $row['id']."       ",$row['campo'],"<br> ";
}
?>
