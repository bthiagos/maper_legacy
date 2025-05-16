<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
$id = $_REQUEST["cod"];



// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["titulo"] == "")) {
		$titulo = $_POST["titulo"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO TÍTULO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["lista"] == "")) {
		$lista = $_POST["lista"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO LISTA OBRIGATÓRIO".'\n';
	}

	

	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msgErro);
	} else {
				// Gravando dados no banco
				$sql = "UPDATE conteudo_aplicacoes SET titulo = '$titulo', lista = '$lista' WHERE id = '$id'";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("APLICAÇÃO ALTERADA COM SUCESSO!");
					redireciona("conteudo_aplicacoes.php");
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
				APLICAÇÕES
			</div>
			<?php
				//EDIT
				$sql = mysql_query("SELECT * FROM conteudo_aplicacoes WHERE id = '$id'");
				$sql = mysql_fetch_array($sql);
				
				$titulo = $sql["titulo"];
				$lista = $sql["lista"];
			?>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1&cod=<?=$id?>" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			  	
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Aplicação: </span> </div><input type="text" style="width: 30%;" name="titulo" value="<?=$titulo?>" class="form_style"> 
				</div>
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Exemplos (separe itens com ;): </span> </div><input type="text" style="width: 30%;" name="lista" value="<?=$lista?>" class="form_style"> 
				</div>
			
			
					<p align='center'><input style="margin-top: 0px;" type="submit" value="CADASTRAR" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
	
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				

		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
		
		
			</div>
	</div>
	
			</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>