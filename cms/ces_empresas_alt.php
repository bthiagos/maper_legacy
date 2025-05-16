<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

if ($_REQUEST['edit']) {
	$codigo = $_REQUEST['cod'];
	$sql = "SELECT * FROM empresa_cargos WHERE id = $codigo";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$empresa = $linha["empresa"];
	
	
}

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	$codigo = $_REQUEST['cod'];	
	// EMPRESA 
	if (!($_POST["empresa"] == "")) {
		$empresa  = trim($_POST["empresa"]);
	} else {
		$ok = 0;
	}
	
	
	
	if ($ok) {


		
	
		
											
			
		// Gravando dados no banco
			$sql = "UPDATE  empresa_cargos SET empresa='$empresa' WHERE id='$codigo'";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Empresa alterada com sucesso!");
				redireciona("ces_empresas.php");
				
			
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
				<img src="imagens/barra_empresa_cargos.gif" alt="Cadastro de Empresa" title="Cadastro de Empresa" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="ces_empresas_alt.php?cadastra=1&cod=<?=$codigo?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Empresa: </span> </div><input type="text" size="50" name="empresa" value="<?=$empresa?>" class="form_style">
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