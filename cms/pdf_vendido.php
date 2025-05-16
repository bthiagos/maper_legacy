<?php
session_start();
require_once("conn.php");

$liberado = false;
$cod_novo = "";

if(isset($_GET["p"]) and isset($_GET["g"])) {
   $g = $_GET["g"];
   $p = $_GET["p"];
   $acesso = mysql_query("SELECT id FROM aplicacoes WHERE grupo = '$g'");
   while($ac = mysql_fetch_array($acesso)) {
      if($p == md5($ac["id"])) {
        $cod_novo = $ac["id"];
        $liberado = true;
      }
   }
}

if(isset($_SESSION["id_usuario_adm"]) and isset($_SESSION["login_adm"])) {
    $liberado = true;
}

if(!$liberado) {
    echo "<h1 style='text-align: center;'>Você não tem permissão para acessar este relatório.</h1>"; 
} else {
    
require_once("library.php");
$orga = $_REQUEST["orga"];

if($cod_novo == "") {
    $cod = $_REQUEST["id"];
} else {
    $cod = $cod_novo;
}

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
	 


$url = "http://www.appweb.com.br/cms/prim_pagi_resu_vendido.php?id=$cod&orga=$orga&commit=$commit";
$resultado_url = executa_url("$url");
require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($resultado_url);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("app_".$nombre.".pdf");


}
?>
