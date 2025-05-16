<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM  ce_contatos WHERE codigo=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Contato excluida com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// contato 
	if (!($_POST["contato"] == "")) {
		$contato  = trim($_POST["contato"]);
	} else {
		$ok = 0;
	}
	
	// email 
	if (!($_POST["e-mail"] == "")) {
		$email  = trim($_POST["e-mail"]);
	} else {
		$ok = 0;
	}
	
	
	if (!($_POST["grupo"] == "")) {
		$grupo = trim($_POST["grupo"]);
	} else {
		$ok = 0;
	}
	
	$sql = "SELECT * FROM ce_contatos WHERE grupo=$grupo and email='$email'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
		$ok = 0;
		$msg = 1;
	}
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		if ($msg == 1) {
			alert("O E-mail $email já foi cadastrado no grupo!");
		}else{
			alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		}

	} else {
				
			// Gravando dados no banco
			$sql = "INSERT INTO ce_contatos (contato,grupo,email) VALUES('$contato','$grupo','$email')";
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Contato cadastrado com sucesso!");
				redireciona("contatos_cadastra.php");
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
				<img src="imagens/cadastro_contatos.gif" alt="Cadastro de Contatos" title="Cadastro de Contatos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="contatos_cadastra.php?cadastra=1" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Contato: </span> </div><input maxlength="200" type="text" size="50" name="contato" value="<?=$contato?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					
					<select name="grupo" class="form_style">
					<option>Selecione</option>
					
					
					<?
					
					$sql = "SELECT * FROM  ce_grupos_contatos ORDER BY grupo";
					$result = mysql_query($sql);
					
					while ($linha = mysql_fetch_assoc($result)) {
					?>
						<option value="<?=$linha["codigo"]?>"><?=$linha["grupo"]?></option>
					<?
						
						
						
					}
					
					?>
					</select>
				</div>
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="50" maxlength="200" name="e-mail" value="<?=$email?>" class="form_style">
				</div>

					<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
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