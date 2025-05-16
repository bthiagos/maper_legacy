<?php
    include("../conn.php");
    
    $protocolo = $_POST["protocolo"];
    
    $sql = mysql_query("SELECT protocolo FROM protocolos WHERE protocolo = '$protocolo'");
    if(mysql_num_rows($sql) == 0) {
        echo "falha";
    }
?>