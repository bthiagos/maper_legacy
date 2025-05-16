<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$sql = "DELETE FROM pdi_feedbacks WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Feedback excluido com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// texto 
	if (!($_POST["feedback"] == "")) {
		$feedback  = trim($_POST["feedback"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["competencia"] == "Selecione")) {
		$competencia  = trim($_POST["competencia"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["nota"] == "Selecione")) {
		$nota  = trim($_POST["nota"]);
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
			$sql = "UPDATE pdi_feedbacks SET  id_competencia='$competencia', nota='$nota', feedback='$feedback' WHERE id=$id";


			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Feedback alterado com sucesso!");
				redireciona("pdi_gerencia.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

if ($_REQUEST["cod"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM pdi_feedbacks WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$competencia = $linha["id_competencia"];
	$nota = $linha["nota"];
	$feedback = $linha["feedback"];

	//echo "$competencia - $nota - $feedback <br/>";
	//echo $sql;
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
				<img src="imagens/barra_grupos_edit.gif" alt="Cadastro de Organizações" title="Cadastro de Organizações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pdi_gerencia_alt.php?cadastra=1&cod=<?=$id;?>" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Competencia: </span> </div>
				<select name="competencia" class="form_style">
				<option value="Selecione">Selecione</option>
				<?

				$sql = "SELECT * FROM competencias ORDER BY ordem ASC";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($competencia == $linha["ordem"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["ordem"]?>" <?=$select?> ><?=$linha["descricao"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>


			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Nota: </span> </div>
				<select name="nota" class="form_style">
				<option value="Selecione">Selecione</option>
					<option value="0" <? if ($nota == 1) { echo " SELECTED "; }  else { echo ""; }?> >00</option>
					<option value="1" <? if ($nota == 1) { echo " SELECTED "; }  else { echo ""; }?> >01</option>
					<option value="2" <? if ($nota == 2) { echo " SELECTED "; }  else { echo ""; }?> >02</option>
					<option value="3" <? if ($nota == 3) { echo " SELECTED "; }  else { echo ""; }?> >03</option>
					<option value="4" <? if ($nota == 4) { echo " SELECTED "; }  else { echo ""; }?> >04</option>
					<option value="5" <? if ($nota == 5) { echo " SELECTED "; }  else { echo ""; }?> >05</option>
					<option value="6" <? if ($nota == 6) { echo " SELECTED "; }  else { echo ""; }?> >06</option>
					<option value="7" <? if ($nota == 7) { echo " SELECTED "; }  else { echo ""; }?> >07</option>
					<option value="8" <? if ($nota == 8) { echo " SELECTED "; }  else { echo ""; }?> >08</option>
					<option value="9" <? if ($nota == 9) { echo " SELECTED "; }  else { echo ""; }?> >09</option>
					<option value="10" <? if ($nota == 10) { echo " SELECTED "; }  else { echo ""; }?> >10</option>
				</select>
			</div>
			
				
				<div id="linha_form" style="height: auto">
					<div id="label">
						<span class="label_fonte">Feedback:</span>
					</div>
					<textarea name="feedback" class="form_style" cols="100" rows="10"><?=$feedback;?></textarea>
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