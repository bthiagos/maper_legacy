<?
include("conn.php");
$id = $_POST["id"];
$post = $_POST["last"];
if($id != 0) {
    $sql = "SELECT *
    	FROM `grupos`
    	where `id_organizacao` = $id
    	ORDER BY `nome`";
    $result = mysql_query($sql);
    ?>
    
    <? 
    while ($linha = mysql_fetch_assoc($result)) {
    if($post == $linha["id"]) { $sel = 'selected = "selected"'; } else { $sel = ""; }
        echo '<option value="'.$linha["id"].'" '.$sel.'>'.$linha["nome"].'</option>';
    }
} else {
    echo "fail";
}
?>