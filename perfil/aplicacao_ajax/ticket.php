<?php
include("../conn.php");

$ticket = $_POST["ticket"];
$organizacao = $_POST["organizacao"];
$grupo = $_POST["grupo"];
$lang = $_POST["lang"];

$sql_ticket = mysql_query("SELECT * FROM gerador_tickets WHERE numero_ticket = '$ticket' and organizacao = '$organizacao'");

if(mysql_num_rows($sql_ticket) == 0) {
    $msg = "O ticket não corresponde à organização.";
    if($lang == "en") { $msg = "The ticket does not match the organization."; }
    if($lang == "es") { $msg = "El boleto no coincide con la organización."; }
    echo $msg;
} else {
    
    $ticket_unico = mysql_result($sql_ticket,0,"ticket_unico");
    $utilizado = mysql_result($sql_ticket,0,"utilizado");
    
    if($ticket_unico != 1) {
        $ticket_existe = mysql_query("SELECT * FROM gerador_tickets WHERE numero_ticket = '$ticket' and organizacao = '$organizacao' and grupo = '$grupo'");
        if(mysql_num_rows($ticket_existe) == 0) {
            $msg = "O ticket não corresponde ao grupo.";
            if($lang == "en") { $msg = "The ticket does not match the group."; }
            if($lang == "es") { $msg = "El boleto no coincide con el grupo."; }
            echo $msg;
        } else {
            if($utilizado == 1) {
                $msg = "O ticket já foi utilizado.";
                if($lang == "en") { $msg = "The ticket has already been used."; }
                if($lang == "es") { $msg = "El billete ya se ha utilizado."; }
                echo $msg;
            } else {
                echo 1;
            }
        }
    } else {
        echo 1;
    }

}

?>