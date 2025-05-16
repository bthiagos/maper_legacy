<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
$id = $_REQUEST["id"];

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	if (!($_POST["titulo"] == "")) {
		$titulo = $_POST["titulo"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO TÍTULO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["subtitulo"] == "")) {
		$subtitulo = $_POST["subtitulo"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO SUBTÍTULO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["descricao"] == "")) {
		$descricao = $_POST["descricao"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO DESCRIÇÃO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["conteudo"] == "")) {
		$conteudo = $_POST["conteudo"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO CONTEÚDO OBRIGATÓRIO".'\n';
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
			$sql = "UPDATE coach_noticias SET titulo='$titulo',subtitulo='$subtitulo',descricao='$descricao',conteudo='$conteudo',foto='$arquivo' WHERE id = '$id'";
				
			//echo $sql;
			if (mysql_query($sql)) {
				alert("NOTÍCIA CADASTRADO COM SUCESSO!");
				redireciona("coach_cnoticias.php");
			} else {
				die("Erro: " . mysql_error());
			}
			
			}else{
				// Gravando dados no banco
			$sql = "UPDATE coach_noticias SET titulo='$titulo',subtitulo='$subtitulo',descricao='$descricao',conteudo='$conteudo' WHERE id = '$id'";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("NOTÍCIA CADASTRADO COM SUCESSO!");
					redireciona("coach_cnoticias.php");
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
				COACH - Notícias
			</div>
			<?php
				$sql = mysql_query("SELECT * FROM coach_noticias WHERE id = '$id'");
				$sql = mysql_fetch_array($sql);
				
				$titulo = $sql["titulo"];
				$subtitulo = $sql["subtitulo"];
				$descricao = $sql["descricao"];
				$conteudo = $sql["conteudo"];
				$foto = $sql["foto"];
			?>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1&id=<?=$id?>" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			  	
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Título: </span> </div><input type="text" style="width: 30%;" name="titulo" value="<?=$titulo?>" class="form_style"> 
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Subtítulo: </span> </div><input type="text" style="width: 30%;" name="subtitulo" value="<?=$subtitulo?>" class="form_style"> 
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Descrição: </span> </div><textarea style="width: 40%; height: 70px;" name="descricao"  class="form_style"><?=$descricao?></textarea>
				</div>
				
				<div id="linha_form" style="margin-top: 60px;">
					<div id="label"> <span class="label_fonte">Conteúdo: </span> </div><textarea style="width: 40%; height: 100px;" name="conteudo"  class="form_style"><?=$conteudo?></textarea>
				</div>
				
				<div id="linha_form" style="margin-top: 90px;">
					<div id="label"> <span class="label_fonte">Foto: </span> </div><input type="file" style="width: 30%" name="foto" value="<?=$foto?>" class="form_style"> 
				</div>
			
			
					 
					<p align='center'><input style="margin-top: 10px;" type="submit" value="CADASTRAR" class="form_style"></p>
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