<?php

require_once("conn.php");
require_once("library.php");
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];
	
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}



$sql = " SELECT * FROM aplicacoes$tabela_commit WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);
$pNome = $linha["nome"]; 

$url2 = "http://www.appweb.com.br/cms/modelo_barra_vendido.php?id=$cod&orga=$orga&commit=$commit";
executa_url("$url2");
	


$url = "http://www.appweb.com.br/cms/prim_pagi_resu_vendido.php?id=$cod&orga=$orga&commit=$commit";
$resultado_url = executa_url("$url");

require_once("dompdf/dompdf_config.inc.php");


$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
//shell_exec("php dompdf/dompdf.php App_Web.pdf arquivo.html");


//$dompdf->stream("App_Web.pdf");

file_put_contents("PDF_COMMIT/$cod"."_".$pNome.".pdf", $dompdf->output()); 
?>
