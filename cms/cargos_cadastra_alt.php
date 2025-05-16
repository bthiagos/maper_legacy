<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['edit']) {
	$codigo_empresa = $_REQUEST["empresa"];
	$codigo_cargo = $_REQUEST['cod'];
	$sql = "SELECT * FROM cargos WHERE id= $codigo_cargo";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$cargo = $linha["cargo"];
	
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	$codigo_empresa = $_REQUEST["empresa"];
	$codigo_cargo = $_REQUEST['cod'];
		
	// EMPRESA 
	if (!($_POST["cargo"] == "")) {
		$cargo  = trim($_POST["cargo"]);
	} else {
		$ok = 0;
	}
	
	$codigo_empresa = $_REQUEST["cod"];
	
	
	if ($ok) {
		
											
			
		// Gravando dados no banco
			$sql = "UPDATE cargos SET cargo='$cargo' WHERE id = $codigo_cargo";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Cargo alterado com sucesso!");
				redireciona("cargos_cadastra.php?cod=$codigo_empresa");
				
			
			
			}
	
 	}
}
 	
 	
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
				<img src="imagens/barra_cargos.gif" alt="Cadastro dos Cargos" title="Cadastro dos Cargos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cargos_cadastra_alt.php?cadastra=1&cod=<?=$codigo_cargo?>&empresa=<?=$codigo_empresa?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Cargo: </span> </div><input type="text" size="50" name="cargo" value="<?=$cargo?>" class="form_style">
				</div>

					<p align="center"><input type="submit" value="Alterar" class="form_style"></p>
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
<?if ($frase) {
	alert($frase);
}?>
</html>