<?php
require("conn.php");

$valor = $_POST["valor"];
$tipo = $_POST["tipo"];

$sel = mysql_query("SELECT * FROM seis_meses");
$sel = mysql_fetch_array($sel);
$app = $sel["app"];
$commit = $sel["commit"];

if($tipo == 'app') {
    mysql_query("UPDATE seis_meses SET app = '$valor'");
}

if($tipo == 'commit') {
    mysql_query("UPDATE seis_meses SET commit = '$valor'");
}

?>