<?php
ini_set("display_errors",1);
require_once("conn.php");

if(isset($_POST["ultimo_id"])) {
   $sql = mysql_query("SELECT * FROM pc_pergunta ORDER BY id DESC LIMIT 1");
   echo mysql_result($sql,0,"id");
} else {

$ordem = explode("|",$_REQUEST["ordem"]);
array_pop($ordem);
array_shift($ordem);
$tam = sizeof($ordem);

for($j = 0; $j < $tam; $j++) {
    mysql_query("UPDATE pc_pergunta SET ordem = '".$j."' WHERE id = '".$ordem[$j]."'");
}

}

?> 