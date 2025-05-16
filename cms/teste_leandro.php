<?php

require_once("library.php");
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];
	


$url2 = "http://www.appweb.com.br/cms/teste_graf55.php?id=$cod&orga=$orga";
executa_url("$url2");
	


$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta.php?id=$cod&orga=$orga";
$resultado_url = executa_url("$url");
require_once("dompdf/dompdf_config.inc.php");


$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");

?>
