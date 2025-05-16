<?php
header("Content-type: application/vnd.ms-word");
//header("content-disposition: attachment;filename=FILENAME.doc"); 

require_once("conn.php");
require_once("library.php");
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];
	
$sql = mysql_query("SELECT nome,respostas as r,LENGTH(respostas) as resp FROM aplicacoes WHERE id = '$cod'");
$sql = mysql_fetch_array($sql);
$nombre = $sql["nome"];
$nombre = str_replace(" ","_",$nombre);
$nombre = strtolower($nombre);

$strres = "";
if($sql["resp"] < 100) {
    $diminui = 100 - $sql["resp"];
    for($o = 0; $o < $diminui; $o++) {
        $random = rand(0,1);
        
        if($random == 0) {
            $strres .= "a";
        }
        if($random == 1) {
            $strres .= "b";
        }
    }
    $novares = $sql["r"].$strres;
    mysql_query("UPDATE aplicacoes SET respostas = '$novares' WHERE id = '$cod'");
}
    
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

if($_SESSION["organizacaon"]){
	$verifica = verificarOrganizacao($cod,$commit);
	if(!$verifica){
		echo "Organização diferente do seu login.Proibido a visualização.";
		exit;
	}
}

$sql = " SELECT * FROM aplicacoes WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);
$pNome = $linha["nome"]; 

$url2 = "http://www.appweb.com.br/cms/teste_graf55.php?id=$cod&orga=$orga&commit=$commit";
executa_url("$url2");
	
header("content-disposition: attachment;filename=app_".$nombre.".doc"); 

$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta_word.php?id=$cod&orga=$orga&commit=$commit";
$resultado_url = executa_url("$url");

/*

require_once("dompdf/dompdf_config.inc.php");


$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
//shell_exec("php dompdf/dompdf.php App_Web.pdf arquivo.html");


$dompdf->stream("app_".$nombre.".pdf");

//file_put_contents("PDF_APPWEB/$pNome.pdf", $dompdf->output()); 
*/
?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 9">
<meta name=Originator content="Microsoft Word 9">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->

<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:View>Print</w:View>
  <w:DoNotHyphenateCaps/>
  <w:PunctuationKerning/>
  <w:DrawingGridHorizontalSpacing>9.35 pt</w:DrawingGridHorizontalSpacing>
  <w:DrawingGridVerticalSpacing>9.35 pt</w:DrawingGridVerticalSpacing>
 </w:WordDocument>
</xml><![endif]-->
<style>
</head>
<body>
<style>
    body {
        line-height: 18px;
        font-size: 12px!important;
    }
</style>
  <? echo $resultado_url; ?>
</body>
</html>