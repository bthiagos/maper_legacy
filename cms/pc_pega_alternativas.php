<?php
    include("conn.php");
    $id_perg = $_POST["id_perg"];
    $sql = mysql_query("SELECT id, alternativa FROM pc_alternativa WHERE id_pergunta = '$id_perg' ORDER BY id ASC");
    
    $alts = "";
    while($alt = mysql_fetch_array($sql)) {
        $alts .= "<option value='".$alt["id"]."'>".$alt["alternativa"]."</option>";
    }
    echo utf8_encode($alts);
?>