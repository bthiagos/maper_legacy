<?php
require_once("conn.php");

$id_pesq = $_POST["id_pesq"];
$questao = utf8_decode($_POST["questao"]);
$tipo = utf8_decode($_POST["tipo"]);
$alts = utf8_decode($_POST["alts"]);
$camps = utf8_decode($_POST["camps"]);

$alts = explode("|||",$alts);
$alts_tam = sizeof($alts);

$camps = explode("|||",$camps);

$ultima_ordem = mysql_query("SELECT ordem FROM pc_pergunta ORDER BY ordem DESC LIMIT 1");
$ultima_ordem = mysql_result($ultima_ordem,0,"ordem");
$ultima_ordem++;

mysql_query("INSERT INTO pc_pergunta (id_pesquisa, pergunta,tipo,ordem) VALUES ('$id_pesq','$questao','$tipo','$ultima_ordem')");
$idperg = mysql_insert_id();

if($tipo == "Fechado") {
for($i = 0; $i < $alts_tam-1; $i++) {
    mysql_query("INSERT INTO pc_alternativa (id_pergunta, alternativa, campo_digitavel) VALUES ('$idperg','".$alts[$i]."','".$camps[$i]."')");
}
}
?> 