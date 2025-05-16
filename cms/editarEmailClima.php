<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
if ($_REQUEST["edit"]) {
	$cod = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM clima_Email WHERE id = $cod";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$grupo = $linha["grupo"];
	$nome = $linha["nome"];
	$email = $linha["email"];
	
}


?>



<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM clima_Email WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Grupo excluido com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	$cod = $_REQUEST["cod"];
		
	// cliente 
	if ($_POST["grupo"] != "") {
		$grupo = $_POST["grupo"];
	} else {
		alert("Campo Grupo Obrigatório!");
		$ok = 0;
	}
	
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
	} else {
		alert("Campo Nome Obrigatório!");
		$ok = 0;
	}
	
	if (addslashes(trim($_POST["email"])) == "") {
		$ok = 0;
		$email = addslashes(trim($_POST["email"]));
		alert("Preencha o campo E-mail corretamente!");
		//redireciona("gerar_tickets.php");
		} elseif (!validar_email(addslashes(trim($_POST["email"]))))  {
			$ok = 0;
			alert("E-mail Inválido!");
			//redireciona("gerar_tickets.php");
			$email = addslashes(trim($_POST["email"]));
		} else {
			$email = addslashes(trim($_POST["email"]));
		}
	
	
	
	
			if(!$ok){
				alert("Erro ao cadastrar,algum campo incorreto!");
			} else {
				// Gravando dados no banco
				//$sql = "INSERT INTO clima_Email (nome, email, grupo) VALUES ('$nome', '$email', '$grupo')";				
				$sql = "UPDATE clima_Email SET nome='$nome',email='$email', grupo='$grupo' WHERE id=$cod";				
				// Confirmacao de insert
				if (mysql_query($sql)) {					
					alert("E-mail alterado com sucesso!");
					redireciona("cadastrarEmailClima.php");
				} else {
					alert("Erro ao cadastrar,algum campo incorreto!");
					//redireciona("gerenciarEmailClima.php");
				}					
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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Editar E-mail</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="editarEmailClima.php?cadastra=1&cod=<?=$_REQUEST["cod"]?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					<select name="grupo" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM clima_GrupoEmail ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								if ($grupo == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}						
								
							?>
						
						<option value="<?=$linha["id"]?>" <?=$select?>><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>
				

				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome:</span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="50" name="email" value="<?=$email?>" class="form_style">
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