<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?


// --- INICIO Efetuando o cadastro
if ($_REQUEST['editar']) {
	
	// Varificacao de campos
	$ok = 1;
	
	$cod = $_REQUEST["cod"];
	
	// Grupo 
	if (!($_POST["Grupo"] == "")) {
		$Grupo  = trim($_POST["Grupo"]);
	} else {
		$ok = 0;
	}
	
	// desc 
	if (!($_POST["desc"] == "")) {
		$desc  = trim($_POST["desc"]);
	} else {
		$ok = 0;
	}
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
				
			// Gravando dados no banco
			$sql = "UPDATE  ce_grupos_contatos SET grupo='$Grupo', descricao='$desc' WHERE codigo=".$cod;
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Grupo alterado com sucesso!");
				redireciona("grupos_gerencia.php");
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
				<img src="imagens/alteracao_grupos.gif" alt="Alteração de Novos Grupos" title="Alteração de Novos Grupos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<?
			if ($_REQUEST["alterar"]) {
				$cod = $_REQUEST["cod"];
				$sql = "SELECT * FROM ce_grupos_contatos WHERE codigo=".$cod;
				$result = mysql_query($sql);
				$linha = mysql_fetch_assoc($result);
				$Grupo = $linha["grupo"];
				$desc = $linha["descricao"];
			}
			?>
			
			
			
			
			<form action="grupos_gerencia_alt.php?editar=1&cod=<?=$cod;?>" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div><input type="text" size="50" name="Grupo" value="<?=$Grupo?>" class="form_style">
				</div>
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Descrição: </span> </div><textarea rows="10" cols="60" name="desc"><?=$desc?></textarea>
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