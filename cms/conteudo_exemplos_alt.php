<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 <?
	if($_REQUEST["cod"])
	{
		$cod = $_REQUEST["cod"];
	}
 ?>
<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM conteudo_exemplos WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("EXEMPLO EXCLUÍDO COM SUCESSO!");
		
	}
	
}
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["nome"] == "")) {
		$nome = $_POST["nome"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO NOME OBRIGATÓRIO".'\n';
	}

	

			// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msgErro);
	} else {
		
			if($_FILES[foto][name]) {
			$dir = "uploaded";			
			$file = $_FILES[foto];			
			$sExt = substr(strrchr($file["name"], "."),1);
			$sExt = strtolower($sExt);
			$arquivo = time().".".$sExt;		
			move_uploaded_file($_FILES[foto][tmp_name], $dir . "/" . $arquivo);	
			$sql = "UPDATE conteudo_exemplos SET nome = '$nome', link = '$arquivo' WHERE id = '$cod'";
			//echo $sql;
			if (mysql_query($sql)) {
				alert("EXEMPLO ALTERADO COM SUCESSO!");
				redireciona("conteudo_exemplos.php");
			} else {
				die("Erro: " . mysql_error());
			}
			
			}else{
				// Gravando dados no banco
				$sql = "UPDATE conteudo_exemplos SET nome = '$nome' WHERE id = '$cod'";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("EXEMPLO CADASTRADO COM SUCESSO!");
					redireciona("conteudo_exemplos.php");
				}
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
				EXEMPLOS
			</div>
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<?php
				$sql = "SELECT * FROM conteudo_exemplos WHERE id = '$cod'";
				
				$sql = mysql_query($sql);
				$sql = mysql_fetch_array($sql);
				
				$nome = $sql["nome"];
				
			?>
			<form enctype="multipart/form-data" action="?cadastra=1&cod=<?=$cod?>" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			  	
		<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome do Exemplo: </span> </div><input type="text" style="width: 30%;" name="nome" value="<?=$nome?>" class="form_style"> 
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Arquivo Exemplo: </span> </div><input type="file" style="width: 30%;" name="foto" value="<?=$foto?>" class="form_style"> 
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
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>