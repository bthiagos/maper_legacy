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
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {

			
		// Gravando dados no banco
		$sql = "INSERT INTO pdi_feedbacks (id_competencia,nota,feedback) VALUES ('$competencia',$nota,'$feedback')";
		
			echo $sql;

		// Confirmacao de insert
		if (mysql_query($sql)) {					
			alert("Feedback cadastrado com sucesso!");
			redireciona("pdi_gerencia.php");
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

			<div id="info" style="height: 25px;"> 
				<div style="font-family: Arial; font-size: 16px; color: #727272;">Cadastro de Feedback</div>
			</div>

			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pdi_gerencia.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data">
			
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
					<option value="0">00</option>
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
					<option value="5">05</option>
					<option value="6">06</option>
					<option value="7">07</option>
					<option value="8">08</option>
					<option value="9">09</option>
					<option value="10">10</option>
				</select>
			</div>
			
				
				<div id="linha_form" style="height: auto">
					<div id="label">
						<span class="label_fonte">Feedback:</span>
					</div>
					<textarea name="feedback" class="form_style" cols="100" rows="10"></textarea>
				</div> 
				
				
				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			
			
				<!-- INICIO - DIV info - Barra de informacao -->

				<div id="info" style="height: 25px;"> 

					<div style="font-family: Arial; font-size: 16px; color: #727272;">Feedback Cadastrados</div>

				</div>

				<!-- INICIO - DIV info - Barra de informacao -->
		
		
		
					<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
					<div id="caixa_table">
			


				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center"><?=utf8_decode("Competência")?></td>
						<td align="center">Nota</td>
						<td align="center">Feedback</td>
						<td align="center" width="1%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "
					SELECT
						pdi_feedbacks.id, 
						pdi_feedbacks.id_competencia, 
						pdi_feedbacks.nota, 
						pdi_feedbacks.feedback, 
						competencias.descricao
					FROM
						pdi_feedbacks
						INNER JOIN
						competencias
						ON 
							pdi_feedbacks.id_competencia = competencias.ordem
					ORDER BY
						pdi_feedbacks.id_competencia, pdi_feedbacks.nota
				";

				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
					$i++;
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>			
		
				<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center"  width="1%" nowrap><?=$i?></td>

						<td align="center" >
						<?=$linha["id_competencia"]?> | <?=$linha["descricao"]?>
						</td>	
						
						<td align="center" >
						<?=$linha["nota"]?>
						</td>	
						
						<td align="center" >
						<?=$linha["feedback"]?>
						</td>	

						
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="pdi_gerencia_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="pdi_gerencia.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o Feedback?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
				</tr>
				<?
				}
				?>
				</table>


			</div> <!-- FIM CAIXA ENGLOBA GERENCIAMENTO -->
		
		
		
		
		
		
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