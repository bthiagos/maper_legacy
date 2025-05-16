<?php
    include("conn.php");
    $req = $_POST["update_value"];
    if($req == "Nenhum") {
        $req = 0;
    } else {
        $getid = mysql_query("SELECT * FROM perfil_cargos WHERE cargo = '$req'");
        $getid = mysql_fetch_array($getid);
        $req = $getid["id"];
    }
    $id = $_POST["id"];
    $upd = "UPDATE aplicacoes SET id_perfil = '$req' WHERE id = '$id'";
    mysql_query($upd);
    echo $_POST["update_value"];
?>