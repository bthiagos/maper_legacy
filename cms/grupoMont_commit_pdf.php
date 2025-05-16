<?
ini_set("memory_limit", "128M");

session_start();
require_once("conn.php");
require_once("library.php");

$where = $_REQUEST["wherea"];


$url4 = "http://www.appweb.com.br/cms/grupoMont_commit_pag.php?wherea=$where";
$resultado_url = executa_url("$url4");
	

require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
//shell_exec("php dompdf/dompdf.php App_Web.pdf arquivo.html");


$dompdf->stream("Gráfico_Grupo.pdf");

?>