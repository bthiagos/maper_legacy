<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM organizacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Organização excluida com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// texto 
	if (!($_POST["texto"] == "")) {
		$texto  = trim($_POST["texto"]);
	} else {
		$ok = 0;
	}
	
	$id = $_REQUEST["cod"];
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
	
			
			
			// Gravando dados no banco
			$sql = "UPDATE organizacoes SET  nome='$texto' WHERE id=$id";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Organização alterada com sucesso!");
				redireciona("orga.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

if ($_REQUEST["cod"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM organizacoes WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$nome = $linha["nome"];
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
				<img src="imagens/barra_organiza_edit.gif" alt="Cadastro de Organizações" title="Cadastro de Organizações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="orga_alt.php?cadastra=1&cod=<?=$id;?>" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organizaçao: </span> </div><input type="text" size="50" name="texto" value="<?=$nome?>" class="form_style">
			
			</div>
			

			
				
				
				
				
				<p align="center"><input type="submit" value="Alterar" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			
			

		
		
		
		
		
		
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>