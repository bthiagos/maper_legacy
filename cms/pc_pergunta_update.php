<?php
require_once("conn.php");

$id = $_POST["id"];
$questao = $_POST["questao"];
$tipo = $_POST["tipo"];
$alts = $_POST["alts"];
$camps = $_POST["camps"];

$get = mysql_query("SELECT pergunta, tipo FROM pc_pergunta WHERE id = '$id'");
$questao = mysql_result($get,0,"pergunta");
$tipo = mysql_result($get,0,"tipo");
    
$geta = mysql_query("SELECT id,alternativa, campo_digitavel FROM pc_alternativa WHERE id_pergunta = '$id' ORDER BY id DESC");
while($perg = mysql_fetch_array($geta)) {
    $alternativa .= $perg["alternativa"] . "&&&";
    $campo .= $perg["campo_digitavel"] . "&&&";
    $ids .= $perg["id"] . "&&&";
}

$resp = $questao."|||".$tipo."|||".$alternativa."|||".$campo."|||".$ids;

echo utf8_encode($resp);
?> 