<?php
require("conn.php");

$id = $_POST["id"];

$sql = mysql_query("SELECT salario FROM ce_usuario WHERE CodUsuario = '$id'");
$sql = mysql_fetch_array($sql);
$sql = $sql["salario"];

if($sql == '1') {
    mysql_query("UPDATE ce_usuario SET salario = '0' WHERE CodUsuario = '$id'");
} else {
    mysql_query("UPDATE ce_usuario SET salario = '1' WHERE CodUsuario = '$id'");
}

?>