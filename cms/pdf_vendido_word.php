<?php
header("Cache-Control: ");// leave blank to avoid IE errors
header("Pragma: ");// leave blank to avoid IE errors
header("Content-type: application/octet-stream");

require_once("conn.php");
require_once("library.php");
$orga = $_REQUEST["orga"];
$cod = $_REQUEST["id"];
$commit = $_REQUEST["commit"];

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

if($_SESSION["organizacaon"]){
	$verifica = verificarOrganizacao($cod,$commit);
	if(!$verifica){
		echo "Organização diferente do seu login.Proibido a visualização.";
		exit;
	}
}

$url2 = "http://www.appweb.com.br/cms/modelo_barra_vendido.php?id=$cod&orga=$orga&commit=$commit";
executa_url("$url2");
	 


$url = "http://www.appweb.com.br/cms/prim_pagi_resu_vendido_word.php?id=$cod&orga=$orga&commit=$commit";
$resultado_url = executa_url("$url");

header("content-disposition: attachment;filename=app_".$nombre.".doc"); 


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
