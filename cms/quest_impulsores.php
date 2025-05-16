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
	
	$p_questao =$respostas[0];
	$f_questao = $respostas[1];
	$e_questao = $respostas[2];
	$ag_questao = $respostas[3];
	$ap_questao = $respostas[4];
	
		if(($f_questao > $p_questao) and ($f_questao >= $e_questao) and ($f_questao >= $ag_questao) and ($f_questao >= $ap_questao)){
			
			$f_questao_maior = "style=\"font-weight: bold;\"";
			
		}
		
		if(($e_questao >= $p_questao) and ($e_questao >= $f_questao) and ($e_questao >= $ag_questao) and ($e_questao >= $ap_questao)){
			
			$e_questao_maior = "style=\"font-weight: bold;\"";
			
		}
		
		if(($ag_questao >= $p_questao) and ($ag_questao >= $f_questao) and ($ag_questao >= $e_questao) and ($ag_questao >= $ap_questao)){
			
			$ag_questao_maior = "style=\"font-weight: bold;\"";
			
		}
		
		
		if(($ap_questao >= $p_questao) and ($ap_questao >= $f_questao) and ($ap_questao >= $e_questao) and ($ap_questao >= $ag_questao)){
			
			$ap_questao_maior = "style=\"font-weight: bold;\"";
			
		}
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
				<b>Avaliação Gerencial</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
			<p><b>Resultado</b>:</p>
					
						<table width="40%" border="0" align="left">
							<tr>
								<td width="90px">4   -   Sempre</td>
								<td width="10px" align="left" <?=$p_questao_maior?>>Seja Perfeito = <?=$p_questao?></td>							
							</tr>
							
							<tr>
								<td width="90px">3   -   Quase sempre</td>
								<td width="10px" align="left" <?=$e_questao_maior?>>Seja Esforçado = <?=$e_questao?></td>							
							</tr>
							
							<tr>
								<td width="90px">2   -   Algumas vezes</td>
								<td width="10px" align="left" <?=$f_questao_maior?>>Seja Forte = <?=$f_questao?></td>							
							</tr>
							
							<tr>
								<td width="90px">1   -   Quase nunca</td>
								<td width="10px" align="left" <?=$ap_questao_maior?>>Seja Apressado = <?=$ap_questao?></td>							
							</tr>
							
							<tr>
								<td width="90px" >0   -    Nunca</td>
								<td width="10px" align="left" <?=$ag_questao_maior?>>Seja Agradável  = <?=$ag_questao?></td>							
							</tr>
					</table>

				<br /><br /><br /><br /><br /><br /><br />
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