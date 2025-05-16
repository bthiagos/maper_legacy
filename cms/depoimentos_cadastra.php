<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {		

				$sql = "DELETE FROM aempresa WHERE id=".$_REQUEST['cod'];
				if (mysql_query($sql)) {
					alert("Excluido com sucesso!");
				}
	
}
// --- FIM    Efetuando a exlcusao



// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["nome"] == "")) {
		$nome = addslashes($_POST["nome"]);
	} else {
		$ok = 0;
	}
	
	// local
	if (!($_POST["cargo"] == "")) {
		$cargo = addslashes($_POST["cargo"]);
	} else {
	}
	
	// local
	if (!($_POST["local"] == "")) {
		$local = addslashes($_POST["local"]);
	} else {
	}
	
	// Texto
	if (!($_POST["depoimento"] == "")) {
		$depoimento = nl2br($_POST["depoimento"]);
	} else {
		$ok = 0;
	}
	
	// Texto
	if (!($_POST["tipo"] == "")) {
		$tipo = nl2br($_POST["tipo"]);
	} else {
		$ok = 0;
	}
	
		
	if ($ok) {

		$data = date("Y-m-d");
					
		    //salvando dados no banco
		    $sql = "INSERT INTO depoimentos (depoimento,nome,local,cargo,tipo) values ('$depoimento','$nome','$local','$cargo','$tipo')";
		    if (mysql_query($sql)) {
		    	alert("Depoimento cadastrado com sucesso!");
		    	redireciona("depoimentos_gerencia.php");
		    } else {
		    	// QUERY
		    	
		    	alert("Erro ao cadastra!");
		    	redireciona("depoimentos_cadastra.php");
		    }
		    


	} // OK
	
} // REQUEST

// --- FIM    Efetuando o cadastro

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
				<img src="imagens/barra_cadastro_depoimento.gif" alt="Cadastro de Conteudo" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="depoimentos_cadastra.php?cadastra=1" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo: </span> </div>
						<select name="tipo" class="form_style">
							<option value="1">Organizações</option>
							<option value="2">Profissionais</option>
						</select>
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome: </span> </div><input size="50" name="nome" class="form_style" value="<?=$nome?>" />						
				</div>	
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Cargo: </span> </div><input size="50" name="cargo" class="form_style" value="<?=$cargo?>" />						
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Local: </span> </div><input size="50" name="local" class="form_style" value="<?=$local?>" />						
				</div>

				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Depoimento: </span> </div><textarea rows="20" cols="70" name="depoimento" class="form_style"><?=$depoimento?></textarea>
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
</html>