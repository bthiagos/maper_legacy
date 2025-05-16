<?php
session_start();

require_once("conn.php");




$lang = $_GET["lang"];

$liberado = false;

$cod_novo = "";


$nome_rel = ""; ;
$nome_sql = mysql_query("SELECT nome_relatorio FROM ce_usuario WHERE CodUsuario = '".$_SESSION["id_usuario_adm"]."'") or die(mysql_error());
if(mysql_num_rows($nome_sql) > 0) { $nome_rel = mysql_result($nome_sql,0,"nome_relatorio"); }



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




$id = $_GET["id"];

$check2 = mysql_query("SELECT ticket FROM aplicacoes WHERE id = '$id'");
$num_ticket = mysql_result($check2,0,'ticket');

$check_ticket = mysql_query("SELECT operacional FROM gerador_tickets WHERE numero_ticket = '".$num_ticket."'");
if(mysql_num_rows($check_ticket) != 0) {
    if(mysql_result($check_ticket,0,"operacional") == 1) {
        $liberado = false;
    }                        
}

$permissao = $_SESSION["per_adm"];
if(($permissao == "99991") or ($permissao == "99992")){
  $liberado = true;
}
if(isset($_GET["fm"])) {
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

 

$sql = " SELECT * FROM aplicacoes WHERE id=".$cod; 

$result = mysql_query($sql);

if(mysql_num_rows($result) > 0) {

$linha = mysql_fetch_assoc($result);

$pNome = $linha["nome"]; 
$org = $linha["organizacao"];

} else {
  $pNome = "";
}


//$url2 = "http://www.appweb.com.br/cms/teste_graf55.php?id=$cod&orga=$orga&commit=$commit";

	




$url = $base_cms."novo_relatorio_resultado2.php?id=$cod&org=$org&orga=$orga&commit=$commit&lang=$lang&nome_relatorio=".urlencode($nome_rel);
if(isset($_GET["sn"])) {
  $url .= "&sn";
}

$content =  utf8_encode(executa_url("$url"));

   

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

    $html2pdf = new HTML2PDF('P','A4','pt');

    $html2pdf->WriteHTML($content);

    //echo $content;

    $html2pdf->Output('Maper_'.$pNome.'_relatorio.pdf');

} 

?>

