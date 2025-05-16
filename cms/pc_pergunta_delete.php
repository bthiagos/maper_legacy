<?php
require_once("conn.php");

$id = $_POST["id"];

mysql_query("DELETE FROM pc_pergunta WHERE id = '$id'");
mysql_query("DELETE FROM pc_alternativa WHERE id_pergunta = '$id'");

?> 