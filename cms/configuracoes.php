<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso


// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// valor 
	if (!($_POST["valor"] == "")) {
		$valor  = trim($_POST["valor"]);
	} else {
		$ok = 0;
	}
	
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
	
		
			
			// Gravando dados no banco
			$sql = "UPDATE configuracoes_vendas SET  valor='$valor' WHERE comando='preco_unit'";
			//echo $sql;
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Configurações salvas com sucesso!");
				redireciona("configuracoes.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

?>

<?
$sql = "SELECT * FROM configuracoes_vendas WHERE comando='preco_unit'";
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);
$preco_teste = $linha["valor"];
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
				<img src="imagens/barra_config.gif" alt="Configurações" title="Configurações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="configuracoes.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Valor do Teste: </span> </div><input type="text" size="30" name="valor" value="<?=$preco_teste;?>" class="form_style">
			
			</div>


				<p align="center"><input type="submit" value="Alterar" class="form_style"></p>
				
				
			
				</div></form>
		
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