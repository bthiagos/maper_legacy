<?
//header("Content-Type: text/plain");
ini_set("display_errors", 1);
ini_set("memory_limit", "4096M");
ini_set('max_execution_time',  999); 

$lang = $_GET["lang"];


$where = $_POST["wherea"];
$dados = array("wherea"=>$where);

if($_GET["v"] == 1) {
    $url = "http://www.appweb.com.br/cms/grupoMont_pag_vendas.php?lang=".$lang;
} elseif ($_GET["v"] == 2)  {
    $url = "http://www.appweb.com.br/cms/grupoMont_pag_operacional.php?lang=".$lang;
} else {
    $url = "http://www.appweb.com.br/cms/grupoMont_pag.php?lang=".$lang;
}



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
$output = curl_exec($ch);
$output = preg_replace('/(\>)\s*(\<)/m', '$1$2', $output);
//echo "<pre>";
//echo $output; 
//echo "</pre>"; 
curl_close($ch);

//die();
require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($output);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("Gráfico_Grupo.pdf");
?> 