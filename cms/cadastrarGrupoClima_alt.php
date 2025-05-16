<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM organizacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Organização excluida com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// texto 
	if (!($_POST["texto"] == "")) {
		$texto  = trim($_POST["texto"]);
	} else {
		$ok = 0;
	}
	
	if (!($_POST["orga"] == "Selecione")) {
		$orga  = trim($_POST["orga"]);
	} else {
		$ok = 0;
	}
	
	if	(!$_FILES[img][name]){	
		$ok = 0;
	}
	
	
	$id = $_REQUEST["cod"];
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
	
			
		if	($_FILES[img][name])	{	
			// Redimencionando Imagens --------------

			//diretório destino das imagens dentro da pasta da aplicação...
			//deve ter permissão para escrita chmod(777)...
			$dir = "/home/appweb/public_html/cms/logoEmpresa";
			//recebendo o arquivo multipart vindo do flash...
			$file = $_FILES[img];
			
			$sExt = substr(strrchr($file["name"], "."), 1);
			$sExt = strtolower($sExt);
			$nome_arquivo = time().".".$sExt;
			//finalizando o upload e criando apartir do arquivo temp, multipart, um novo arquivo
			// em nossa pasta de destino. O echo serve para dizer ao flash se deu certo ou não...
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $nome_arquivo);
			$filename ="/home/appweb/public_html/cms/logoEmpresa". $nome_arquivo;
			$percent = 0.5;
			
		/*	// Get new dimensions
			$tamanho = getimagesize($filename);  
			list($width, $height) = getimagesize($filename);
			$new_width =  273; 
			$new_height = $tamanho[1] * $new_width / $tamanho[0]; 
	
			if ($sExt == "jpg") {
			// Resample
			$image_p = imagecreatetruecolor($new_width, $new_height);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($image_p, "/usr/shared/web/prin55/cms2/colecao/$nome_arquivo");			
			}
			*/
	
	

			// Gravando dados no banco
			$sql = "UPDATE clima_GrupoEmail SET  nome='$texto', id_organizacao='$orga', logo='$nome_arquivo' WHERE id=$id";
			
			} else {			
			// Gravando dados no banco
			$sql = "UPDATE clima_GrupoEmail SET  nome='$texto', id_organizacao='$orga' WHERE id=$id";
			}
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Grupo alterado com sucesso!");
				redireciona("cadastrarGrupoClima.php");
			}
	} 
}
	


// --- FIM    Efetuando o cadastro

if ($_REQUEST["cod"]) {
	$id = $_REQUEST["cod"];
	
	$sql = "SELECT * FROM clima_GrupoEmail WHERE id=$id";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$nome = $linha["nome"];
	$orga = $linha["id_organizacao"];
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
			<div id="info">
				<img src="imagens/barra_grupos_edit.gif" alt="Cadastro de Organizações" title="Cadastro de Organizações" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrarGrupoClima_alt.php?cadastra=1&cod=<?=$id;?>" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Grupo: </span> </div><input type="text" size="50" name="texto" value="<?=$nome?>" class="form_style">
			
			</div>
			

			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
				<select name="orga" class="form_style">
				<option value="Selecione">Selecione</option>
				<?
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($orga == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
				
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Logo da Empresa: </span> </div><input type="file" size="50" name="img"  class="form_style">
				</div>
				
				
				
				<p align="center"><input type="submit" value="Alterar" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			
			

		
		
		
		
		
		
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