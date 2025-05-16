<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?php
$url = "http://www.appweb.com.br/cms/perfil_cargos_gerador.php?aplicacoes=".$_REQUEST["aplicacoes"];

$getnome = mysql_query("SELECT nome FROM aplicacoes WHERE id = '".$_REQUEST["aplicacoes"]."'");
$getnome = mysql_fetch_array($getnome);
$palavra = $getnome["nome"];

$palavra = ereg_replace("[^a-zA-Z0-9_]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

$palavra = strtolower($palavra);
$palavra = str_replace(" ","_",$palavra);

$resultado_url = executa_url($url);

require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("perfilcargo_".$palavra.".pdf");
?>