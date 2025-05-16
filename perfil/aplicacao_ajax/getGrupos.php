<?
include("../conn.php");
$id = $_POST["id"];

if($id != 0) {
    $sql = "SELECT *
    	FROM `grupos`
    	where `id_organizacao` = $id
    	ORDER BY `nome`";
    $result = mysql_query($sql);
    ?>
    
    <? 
    while ($linha = mysql_fetch_assoc($result)) {
    if($_POST["select"] == $linha["id"]) { $sel = "selected"; } else { $sel = ""; }
        echo '<option value="'.$linha["id"].'" '.$sel.'>'.utf8_encode($linha["nome"]).'</option>';
    }
} else {
    echo "fail";
}
?>