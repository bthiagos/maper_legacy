<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
	if($_REQUEST["gerar"]){
		if($_REQUEST["commit"]){
			$commit=$_REQUEST["commit"];
			$tabela_commit = "_commit";
		}

$t = "aplicacoes".$tabela_commit;
				
		$i=0;
		while($i<20){
			$peso = "peso_".$i;
			$pesos .=	$_POST[$peso]."|";
			$i++;
		}							
		$pesos = trim($pesos);
		$descricao = nl2br($_POST["descricao"]);
		//echo $pesos;
		$sql_updt = "UPDATE $t SET pesos = '$pesos' , descricao= '$descricao' WHERE id=".$_REQUEST["cod"]; 
		mysql_query($sql_updt);
		
		$cod = $_REQUEST["cod"];
		
		$url = "http://www.appweb.com.br/cms/gerar_laudo.php?id=$cod&orga=$orga&commit=$commit";
		
		$resultado_url = executa_url($url);
	
		require_once("dompdf/dompdf_config.inc.php");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($resultado_url);
		$dompdf->set_paper('a4', 'portrait');
		$dompdf->render();
		$dompdf->stream("App_Web.pdf");
		
	}
		
?>
