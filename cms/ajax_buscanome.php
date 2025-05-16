<?php
    include("conn.php");
    
    $id = $_POST["id"];
    $nome = mysql_query("SELECT * FROm aplicacoes WHERE id = '$id'");
    $nome = mysql_fetch_array($nome);
    echo $nome["id"]."'><span style='text-transform: uppercase;font-family: Arial, Verdana; font-size: 12px;'>".utf8_encode($nome["nome"])."</span>";
?>