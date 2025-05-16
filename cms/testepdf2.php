<?php
require_once("library.php");
$url2 = "http://www.appweb.com.br/cms/teste_graf.php?id=".$_REQUEST["id"];
executa_url("$url2");



$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta2.php?id=".$_REQUEST["id"];
$resultado_url = executa_url("$url");
require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");
?>