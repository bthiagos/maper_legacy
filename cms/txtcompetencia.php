<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?



// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	

	$sql = "SELECT feedbacks_id FROM feedbacks ORDER BY feedbacks_id";
	$result = mysql_query($sql);

			
	while ($linha = mysql_fetch_assoc($result)) {
		
		$nome_campo = "descricao_".$linha["feedbacks_id"];
		
				
	    $sql = "UPDATE feedbacks SET descricao='".$_POST["$nome_campo"]."' WHERE feedbacks_id=".$linha["feedbacks_id"];

		mysql_query($sql);
		
		//echo $sql."<br/><br/>";
		
	}

		alert("Dados alterados com sucesso!");
		//redireciona("txtcompetencia.php");

	
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
				<img src="imagens/barra_cadastro_uder.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="txtcompetencia.php?cadastra=1" method="post" onSubmit="return validaForm()" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<?
			$sql = "SELECT * FROM feedbacks ORDER BY feedbacks_id";
			$result = mysql_query($sql);
			?>
			
			<? while ($linha = mysql_fetch_assoc($result)) { ?>
			
				<div id="linha_form" style="height: auto">
					<div id="label">
						<span class="label_fonte">Competência: #<?=$linha["feedbacks_id"];?></span>
					</div>
					<textarea name="descricao_<?=$linha["feedbacks_id"];?>" class="form_style" cols="65" rows="8"><?=$linha["descricao"]?></textarea>
				</div> 
				
			<? } ?>

			<!--	<div id="linha_form" style="height: auto">
					<div id="label">
						<span class="label_fonte">Texto Completo:</span>
					</div>
					<textarea name="textoCompleto" class="form_style" cols="60" rows="8"><?=$textoCompleto?></textarea>
				</div>-->

	
		

					<p align="center"><input type="submit" value="Cadastrar" class="form_style" style="margin-left: 125px"></p>
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