<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	if (!($_POST["conteudo1"] == "")) {
		$conteudo1 = $_POST["conteudo1"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO CONHEÇA OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["conteudo2"] == "")) {
		$conteudo2 = $_POST["conteudo2"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO SAIBA MAIS OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["conteudo3"] == "")) {
		$conteudo3 = $_POST["conteudo3"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO E-COACH OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["conteudo4"] == "")) {
		$conteudo4 = $_POST["conteudo4"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO PESQUISA DE CLIMA OBRIGATÓRIO".'\n';
	}
	
	

			// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msgErro);
	} else {

				// Gravando dados no banco
				$sql = "UPDATE conteudo_home SET conheca = '$conteudo1', saibamais = '$conteudo2', ecoach = '$conteudo3', pesquisaclima = '$conteudo4' WHERE id = '1'";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("HOME ALTERADA COM SUCESSO!");
					
				}
			}
			
		}		
	


// --- FIM    Efetuando o cadastro

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

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
				HOME
			</div>
			<?php
				$sql = mysql_query("SELECT * FROM conteudo_home");
				$sql = mysql_fetch_array($sql);
				
				$conteudo1 = $sql["conheca"];
				$conteudo2 = $sql["saibamais"];
				$conteudo3 = $sql["ecoach"];
				$conteudo4 = $sql["pesquisaclima"];
			?>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">


				<div id="linha_form" style="margin-top: 0px;">
					<div id="label" style="valign: top;"> <span class="label_fonte">Conheça a APP Web: </span> </div>
					<textarea name="conteudo1" style="width: 50%; height: 100px; font-family: Arial, Verdana;"><?=$conteudo1?></textarea>
				
				</div>
				
				<div id="linha_form" style="margin-top: 80px;">
					<div id="label" style="valign: top;"> <span class="label_fonte">Saiba mais sobre você: </span> </div>
					<textarea name="conteudo2" style="width: 50%; height: 100px; font-family: Arial, Verdana;"><?=$conteudo2?></textarea>
				
				</div>
				
				<div id="linha_form" style="margin-top: 80px;">
					<div id="label" style="valign: top;"> <span class="label_fonte">E-Coach: </span> </div>
					<textarea name="conteudo3" style="width: 50%; height: 100px; font-family: Arial, Verdana;"><?=$conteudo3?></textarea>
				
				</div>
				
				<div id="linha_form" style="margin-top: 80px;">
					<div id="label" style="valign: top;"> <span class="label_fonte">Pesquisa de Clima: </span> </div>
					<textarea name="conteudo4" style="width: 50%; height: 100px; font-family: Arial, Verdana;"><?=$conteudo4?></textarea>
				
				</div>
				
					 
					<p align='center'><input type="submit" style="margin-top: 100px;" value="CADASTRAR" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
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
</html>