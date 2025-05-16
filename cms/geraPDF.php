<?
include("library.php");

$resultado_url = "";
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];

$url = "http://www.agenciapenta.com.br/teste_ser.php?id=$cod&orga=$orga";
$resultado_url = executa_url($url);

require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");
?>