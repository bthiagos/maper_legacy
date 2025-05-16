<?php
session_start();
require_once("conn.php");
require_once("library.php");
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];
$commit = $_REQUEST["commit"];
	
if($_SESSION["organizacaon"]){
	$verifica = verificarOrganizacao($cod,$commit);
	if(!$verifica){
		echo "Organização diferente do seu login.Proibido a visualização.";
		exit;
	}
}

$url2 = "http://www.appweb.com.br/cms/modelo_barra_vendido_2.php?id=$cod&orga=$orga&commit=$commit";
executa_url("$url2");
	 


$url = "http://www.appweb.com.br/cms/prim_pagi_resu_vendido_2.php?id=$cod&orga=$orga&commit=$commit";
$resultado_url = executa_url("$url");
require_once("dompdf/dompdf_config.inc.php");

 
$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");

?>
