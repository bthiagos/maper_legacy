<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// texto 
	if (!($_POST["grupo"] == "")) {
		$grupo  = trim($_POST["grupo"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["orga"] == "")) {
		$orga  = trim($_POST["orga"]);
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
			$sql = "UPDATE aplicacoes SET  grupo='$grupo', organizacao='$orga' WHERE id=$id";
			//echo $sql;
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Aplicação alterada com sucesso!");
				redireciona("aplica_gerencia.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

if ($_REQUEST["cod"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM aplicacoes WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$grupo = $linha["grupo"];
	$orga = $linha["organizacao"];
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
				<img src="imagens/barra_aplica_edit.gif" alt="Cadastro de Aplicações" title="Cadastro de Aplicações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="aplica_alt.php?cadastra=1&cod=<?=$id;?>" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				

			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
				<select name="orga" class="form_style">
				<option value="0">Selecione</option>
				<?
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($grupo == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
			

			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Grupo: </span> </div>
				<select name="grupo" class="form_style">
				<option value="0">Selecione</option>
				<?
				$sql = "SELECT * FROM grupos ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($orga == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
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