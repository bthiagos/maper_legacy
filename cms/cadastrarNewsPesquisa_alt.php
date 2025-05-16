<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['edit']) {
	
	$sql = "SELECT * FROM pesquisa_newsletter WHERE id=".$_REQUEST['cod'];
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$titulo = $linha["titulo"];
	$codigo = $_REQUEST['cod'];
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
		$codigo = $_REQUEST["cod"];
		
	// cliente 
	if (!($_POST["titulo"] == "")) {
		$titulo  = addslashes(trim($_POST["titulo"]));
	} else {
		$ok = 0;
	}
		
	if ($ok) {

		$data =  date("Y-m-d H:i:s");

		
	
		
		if	($_FILES[img][name])	{	
			// Redimencionando Imagens --------------

			//diretório destino das imagens dentro da pasta da aplicação...
			//deve ter permissão para escrita chmod(777)...
			$dir = "/home/appweb/public_html/cms/news";
			//recebendo o arquivo multipart vindo do flash...
			$file = $_FILES[img];
			
			$sExt = substr(strrchr($file["name"], "."), 1);
			$sExt = strtolower($sExt);
			$nome_arquivo = time().".".$sExt;
			//finalizando o upload e criando apartir do arquivo temp, multipart, um novo arquivo
			// em nossa pasta de destino. O echo serve para dizer ao flash se deu certo ou não...
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $nome_arquivo);
			$filename ="/home/appweb/public_html/cms/news". $nome_arquivo;
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
			$sql = "UPDATE pesquisa_newsletter SET 
					titulo='$titulo',imagem='$nome_arquivo'
					WHERE id=$codigo";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Newsletter cadastrado com sucesso!");
				redireciona("cadastrarNewsPesquisa.php");
			} else {
				alert("Erro ao cadastrar,algum campo incorreto!");
				redireciona("cadastrarNewsPesquisa.php");
			}
		}else{
			
			// Gravando dados no banco
			$sql = "UPDATE pesquisa_newsletter SET 
					titulo='$titulo'
					WHERE id=$codigo";
						
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Newsletter cadastrado com sucesso!");
				redireciona("cadastrarNewsPesquisa.php");
			} else {
				alert("Erro ao cadastrar,algum campo incorreto!");
				redireciona("cadastrarNewsPesquisa.php");
			}
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
			<div id="info">
				<b>Cadastro de Newsletter - Pesquisa de Clima</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrarNewsPesquisa_alt.php?cadastra=1&cod=<?=$codigo?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Titulo: </span> </div><input type="text" size="50" name="titulo" value="<?=$titulo?>" class="form_style">
				</div>
				
								
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Imagem: </span> </div><input type="file" size="50" name="img"  class="form_style">
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