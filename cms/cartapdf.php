<?php

require_once("library.php");

$cod = $_REQUEST["cod"];
	
$url = "http://www.appweb.com.br/cms/modelo_carta.php?cod=$cod";
$resultado_url = executa_url("$url");
require_once("dompdf/dompdf_config.inc.php");


$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");

?>
