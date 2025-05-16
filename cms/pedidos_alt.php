<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// status 
	if (!($_POST["status"] == "")) {
		$status  = trim($_POST["status"]);
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
			$sql = "UPDATE pedidos SET  status_pag='$status' WHERE id=$id";
			//echo $sql;
			//echo $sql;
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Alteração realizada com sucesso!");
				redireciona("pedidos_gerencia.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

if ($_REQUEST["cod"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM pedidos WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$status_pag = $linha["status_pag"];
}


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

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
				<img src="imagens/barra_pedidos_altera.gif" alt="Alteração de pedidos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pedidos_alt.php?cadastra=1&cod=<?=$id;?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			

			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Status: </span> </div>
				<select name="status" class="form_style">
				<option value="0">Selecione</option>
				<?
				$sql = "SELECT * FROM status_pedido ORDER BY status_locaweb";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($status_pag == $linha["status_locaweb"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["status_locaweb"]?>" <?=$select?> ><?=$linha["nome_status"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
				

					<p align="center"><input type="submit" value="Alterar" class="form_style"></p>
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