<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?


// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["instrucoes"] == "")) {
		$instrucoes  = trim($_POST["instrucoes"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["descricao"] == "")) {
		$descricao = trim($_POST["descricao"]);
	} else {
		$ok = 0;
	}
	
	
	if (!($_POST["qtdeperguntas"] == "")) {
		$qtdeperguntas = trim($_POST["qtdeperguntas"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["qtderespostas"] == "")) {
		$qtderespostas = trim($_POST["qtderespostas"]);
	} else {
		$ok = 0;
	}
	
	

	
	
	// Se seu campo estiver OK!
	if (!$ok) {

			alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		

	} else {
				
			// Gravando dados no banco
			
				
			if($_FILES[img][name]) {
			$dir = "uploaded";			
			$file = $_FILES[img];			
			$sExt = substr(strrchr($file["name"], "."),1);
			$sExt = strtolower($sExt);
			$arquivo = time().".".$sExt;		
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $arquivo);	
			$sql = "INSERT INTO teste_gratuito_cadastro (nome,descricao,qtdeperguntas,qtderespostas, instrucoes, imagem) VALUES('$nome','$descricao','$qtdeperguntas','$qtderespostas','$instrucoes','$arquivo')";
			//echo $sql;
			} else {
				$sql = "INSERT INTO teste_gratuito_cadastro (nome,descricao,qtdeperguntas,qtderespostas,instrucoes) VALUES('$nome','$descricao','$qtdeperguntas','$qtderespostas','$instrucoes')";
			}
			
			
			// Confirmacao de insert
			if (mysql_query($sql)) {
				
					$id_teste = mysql_query("SELECT id FROM teste_gratuito_cadastro ORDER BY id DESC");
					$id_teste = mysql_fetch_array($id_teste);
					$id_teste = $id_teste["id"];
					
					$sql2 = "INSERT INTO teste_gratuito_perguntas (id_teste,pergunta) VALUES('$id_teste','')";
					
					$sql3 = "INSERT INTO teste_gratuito_respostas (id_teste,resposta) VALUES('$id_teste','')";
					
					if(mysql_query($sql2) AND mysql_query($sql3)) {
					alert("Teste gratuito cadastrado com sucesso!");
					redireciona("gerenciar_gratuitos.php");
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
				<img src="imagens/icoGratuito.png" /> 
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrar_gratuitos.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Ícone Representativo: </span> </div><input type="file" style="width: 330px;" name="img" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome do Teste: </span> </div><input maxlength="200" type="text" style="width: 330px;" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Descrição: </span> </div><textarea name="descricao" style="width: 330px; height: 100px;" class="form_style"><?=$descricao?></textarea>
				</div>
				
				<div id="linha_form" style="margin-top: 85px;">
					<div id="label"> <span class="label_fonte">Instruções: </span> </div><textarea name="instrucoes" style="width: 330px; height: 100px;" class="form_style"><?=$instrucoes?></textarea>
				</div>
				
				<div id="linha_form" style="height: 20px; margin-top: 85px;">
					<div id="label"> <span class="label_fonte">Quantas PERGUNTAS terá? </span> </div><input maxlength="200" type="text" style="width: 30px;  " name="qtdeperguntas" value="<?=$qtdeperguntas?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Quantas ALTERNATIVAS terá? </span> </div><input maxlength="200" type="text" style="width: 30px;" name="qtderespostas" value="<?=$qtderespostas?>" class="form_style">
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