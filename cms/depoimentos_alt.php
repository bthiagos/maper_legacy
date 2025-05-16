<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando o cadastro
if ($_REQUEST['edit']) {
	
	$codigo = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM depoimentos WHERE id=$codigo";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$nome = $linha["nome"];
	$depoimento = $linha["depoimento"];
	$tipo = $linha["tipo"];
	$cargo = $linha["cargo"];
	$local = $linha["local"];
	
	if($tipo == 1){
		$org = "SELECTED";
	}
	
	if($tipo == 2){
		$prof = "SELECTED";
	}

}


if ($_REQUEST['edita']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Cod
	$codigo = $_REQUEST["cod"];
	
	// Nome
	if (!($_POST["nome"] == "")) {
		$nome = addslashes($_POST["nome"]);
	} else {
		$ok = 0;
	}
	
	// local
	if (!($_POST["cargo"] == "")) {
		$cargo = addslashes($_POST["cargo"]);
	} else {
	}
	
	// local
	if (!($_POST["local"] == "")) {
		$local = addslashes($_POST["local"]);
	} else {
	}
	
	// Texto
	if (!($_POST["depoimento"] == "")) {
		$depoimento = nl2br($_POST["depoimento"]);
	} else {
		$ok = 0;
	}
	
	// Texto
	if (!($_POST["tipo"] == "")) {
		$tipo = nl2br($_POST["tipo"]);
	} else {
		$ok = 0;
	}

	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou est em branco, tente novamente!");
	} else {
		
		$sql = "UPDATE depoimentos SET nome='$nome', local='$local', cargo='$cargo', depoimento='$depoimento', tipo='$tipo' WHERE id=".$codigo;
		if (mysql_query($sql)) {
			alert("Depoimento alterado com sucesso!");
			redireciona("depoimentos_gerencia.php");
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
				<img src="imagens/barra_alt_cadastro_user.gif" alt="Alterao de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="depoimentos_alt.php?edita=1&cod=<?=$codigo?>" method="post" onSubmit="return validaForm()" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo: </span> </div>
						<select name="tipo" class="form_style">
							<option value="1" <?=$org?>>Organizações</option>
							<option value="2" <?=$prof?>>Profissionais</option>
						</select>
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome: </span> </div><input size="50" name="nome" class="form_style" value="<?=$nome?>" />						
				</div>	
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Cargo: </span> </div><input size="50" name="cargo" class="form_style" value="<?=$cargo?>" />						
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Local: </span> </div><input size="50" name="local" class="form_style" value="<?=$local?>" />						
				</div>

				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Depoimento: </span> </div><textarea rows="20" cols="70" name="depoimento" class="form_style"><?=$depoimento?></textarea>
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
</html>