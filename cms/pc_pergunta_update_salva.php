<?php
require_once("conn.php");

$id = $_POST["id"];
$questao = utf8_decode($_POST["questao"]);
$tipo = utf8_decode($_POST["tipo"]);
$alts = utf8_decode($_POST["alts"]);
$camps = utf8_decode($_POST["camps"]);
$ids_alts = utf8_decode($_POST["ids_alts"]);

$alts = explode("|||",$alts);
$alts_tam = sizeof($alts);

$camps = explode("|||",$camps);
$ids_alts = explode("|||",$ids_alts);

mysql_query("UPDATE pc_pergunta SET pergunta = '$questao',tipo = '$tipo' WHERE id = '$id'");

$check_sql = mysql_query("SELECT id FROM pc_alternativa WHERE id_pergunta = '".$id."'");
while($check = mysql_fetch_array($check_sql)) {
    if(!in_array($check["id"],$ids_alts)) {
        mysql_query("DELETE FROM pc_alternativa WHERE id = '".$check["id"]."'");
    }
}

if($tipo == "Fechado") {
    for($i = 0; $i < $alts_tam-1; $i++) {
        //mysql_query("INSERT INTO pc_alternativa (id_pergunta, alternativa, campo_digitavel) VALUES ('$id','".$alts[$i]."','".$camps[$i]."')");
        
        //Verifica se já existe
        $check_sql = mysql_query("SELECT * FROM pc_alternativa WHERE id = '".$ids_alts[$i]."'");
        if($alts[$i] != "undefined") {
            if(mysql_num_rows($check_sql) ==0) {
                mysql_query("INSERT INTO pc_alternativa (id_pergunta, alternativa, campo_digitavel) VALUES ('$id','".$alts[$i]."','".$camps[$i]."')");
            } else {
                mysql_query("UPDATE pc_alternativa SET id_pergunta = '$id', alternativa = '".$alts[$i]."', campo_digitavel = '".$camps[$i]."' WHERE id = '".$ids_alts[$i]."'");
            }
        }
    }
}

if($tipo == "Aberto") {
    
}
?> 