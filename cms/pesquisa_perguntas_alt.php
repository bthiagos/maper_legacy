<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['edit']) {
	$cod =$_REQUEST['cod'];
	
	$sql = "SELECT * FROM pesquisa_perguntas WHERE id= $cod";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$id_pesquisa = $linha["id_pesquisa"];
	$pergunta = $linha["perguntas"];
	$texto = $linha["texto"];
		
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	$cod =$_REQUEST['cod'];
		
	// EMPRESA 
	if (!($_POST["pergunta"] == "")) {
		$pergunta  = trim($_POST["pergunta"]);
	} else {
		$ok = 0;
	}
	
	// EMPRESA 
	if (!($_POST["id_pesquisa"] == "")) {
		$id_pesquisa  = trim($_POST["id_pesquisa"]);
	} else {
		$ok = 0;
	}
	
	$texto = $_REQUEST["texto"];
	
	
	if ($ok) {

		// Gravando dados no banco
			$sql = "UPDATE pesquisa_perguntas SET perguntas='$pergunta',texto='$texto',id_pesquisa ='$id_pesquisa' WHERE id = $cod";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Pergunta alterada com sucesso!");
				redireciona("pesquisa_perguntas.php?pesquisa=1&id_pesquisa=$id_pesquisa");
				
			} 	else {
				alert("Pergunta não cadastrado , Erro ao no cadastro!");
				redireciona("pesquisa_perguntas.php");
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
				<b>Cadastro das Perguntas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pesquisa_perguntas_alt.php?cadastra=1&cod=<?=$cod?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Escolha a pesquisa: </span> </div>
					<select name="id_pesquisa" class="form_style">
						<option value=""> Selecione </option>
						<?
							$sql_pesquisa = "SELECT * FROM pesquisas";
							$result_pesquisa = mysql_query($sql_pesquisa);
							while($linha_pesquisa = mysql_fetch_assoc($result_pesquisa)){
								if($id_pesquisa = $linha_pesquisa["id"]){
									$select = " SELECTED ";
								}else{
									$select = " ";
								}
						?>
								
								<option value="<?=$linha_pesquisa["id"]?>" <?=$select?> ><?=$linha_pesquisa["nome"]?></option>
								
								
						<?	}											
						?>				
					</select>
				</div>
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Texto de instrução : </span> </div><textarea rows="3" cols="80" name="texto" class="form_style"><?=$texto?></textarea>
				</div>
			
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Digite a pergunta: </span> </div><textarea rows="3" cols="80" name="pergunta" class="form_style"><?=$pergunta?></textarea>
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