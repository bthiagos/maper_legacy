<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if ($_REQUEST['id']) {
	$depoimentos2 = $_REQUEST["id"];
}
// --- INICIO Efetuando a exlcusao

// --- FIM    Efetuando a exlcusao
if($_REQUEST["cod"])
{
	$cod = $_REQUEST["cod"];
}
		
if($_POST["mensagem"] != ""){
		
		
		
			$mensagem = addslashes($_POST["mensagem"]);
	 
		
	} else {
		$ok=0;
		$frase .= "Campo Mensagem Obrigatório";
	}


	

if ($_REQUEST['cadastra']) {
	
			$sql = "UPDATE `newsletter_email` SET mensagem = '$mensagem' WHERE id  = '$cod'";
			//echo $sql;
			if (mysql_query($sql)) {
				alert("Depoimento cadastrado com sucesso!");
				redireciona("newsletter_email_gerencia.php?cod=" . $depoimentos2);
			} else {
				die("Erro: " . mysql_error());
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
			<?php
			$sql = "SELECT * FROM newsletter_email WHERE id = '$cod'";
			$sql = mysql_query($sql);
			$sql = mysql_fetch_array($sql);
			
			$mensagem = $sql["mensagem"];
			?>
			<div id="info">
				Cadastro de Mensagens
			</div>
			<form action="?cadastra=1&cod=<?=$cod?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
				
		
				
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Mensagem: </span>
					</div>
					<textarea name="mensagem" class="form_style" style="width: 500px; height: 100px"><?=$mensagem?></textarea>
				</div>

				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
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