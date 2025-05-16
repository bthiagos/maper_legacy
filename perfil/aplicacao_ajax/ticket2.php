<?php
include("../conn.php");

$ticket = $_POST["ticket"];
$lang = $_POST["lang"];

$sql_ticket = mysql_query("SELECT * FROM gerador_tickets WHERE numero_ticket = '$ticket'");

if(mysql_num_rows($sql_ticket) == 0) {
    $msg = "O ticket não corresponde à organização.";
    if($lang == "en") { $msg = "The ticket does not match the organization."; }
    if($lang == "es") { $msg = "El boleto no coincide con la organización."; }
    echo $msg;
} else {  
    echo 1;
}
?>