<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

//if($_REQUEST["teste"]){
	
//	session_start();
	$id = $_REQUEST["cod"];

	$sql = " SELECT * FROM testes_gratuitos WHERE id = '$cod'";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	//echo $sql;
	$total = $linha["resposta"];
	
	$respostas = explode("|",$total);
	$v= $respostas[0]; 
	$w= $respostas[1]; 
	$x= $respostas[2];  
	$y= $respostas[3]; 	
	$z= $respostas[4];
	
	//}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<style>
.td01 {
border: 1px #333333 solid;
border-bottom: 0px;
}

.td02 {
	border: 1px #333333 solid;
	border-bottom: 0px;
	border-left: 0px;
}

.td03 {
	border: 1px #333333 solid;
}
		
		
.td04 {
	border: 1px #333333 solid;
	border-left: 0px;
}
		
.tx_preto {
	color: #000000;
}
		
		
.fundo_claro {
	background: #ffffff;
}

.fundo_escuro {
background: #cccccc;
}
		
</style>
<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">			
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<b>Motivograma - Resultado</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
			
			<? 	
			$url2 = "http://www.appweb.com.br/cms/motivograma_grafico.php?v=$v&w=$w&x=$x&y=$y&z=$z";
			executa_url("$url2");
			$nome_img = $v."_".$w."_".$x."_".$y."_".$z."_".".png";
			?>
			<br/>
			<p>
			<img src="motivograma/<?=$nome_img?>">
			</p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
			
			
			
			
				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>