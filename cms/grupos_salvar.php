<?php
    include("conn.php");
    $req = $_POST["update_value"];
    if($req == "Nenhum") {
        $req = 0;
    } else {
        $getid = mysql_query("SELECT * FROM grupos WHERE nome = '$req'");
        $getid = mysql_fetch_array($getid);
        $req = $getid["id"];
    }
    $id = $_REQUEST["id"];
    $upd = "UPDATE aplicacoes SET grupo = '$req' WHERE id = '$id'";
    mysql_query($upd);
    echo $_POST["update_value"];
?>