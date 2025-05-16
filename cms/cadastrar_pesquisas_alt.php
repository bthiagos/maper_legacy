<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	$id=$_REQUEST["cod"];
		
	// NOME 
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
	} else {
		$ok = 0;
	}
	
	$texto = addslashes(nl2br($_REQUEST["texto"]));
	
	
	if ($ok) {

		// Gravando dados no banco
			$sql = "UPDATE pesquisas SET texto='$texto',nome='$nome' WHERE id=$id";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Pergunta cadastrado com sucesso!");
				redireciona("cadastrar_pesquisas.php");
				
			}else {
				alert("Pergunta não cadastrado , Erro ao no cadastro!");
				redireciona("cadastrar_pesquisas_alt.php?cod=$id&edit=1");
					}
			
			}
	
 	}
 	
 	
 	
if ($_REQUEST["edit"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM pesquisas WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$nome = $linha["nome"];
	$texto = $linha["texto"];
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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Cadastro das Pesquisas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrar_pesquisas_alt.php?cadastra=1&cod=<?=$id?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Texto : </span> </div><textarea rows="3" cols="80" name="texto" class="form_style"><?=$texto?></textarea>
				</div>
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome da pesquisa: </span> </div><input type="text" name="nome"  value="<?=$nome?>" size="50" class="form_style" />
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