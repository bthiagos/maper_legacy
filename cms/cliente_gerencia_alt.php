<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
if ($_REQUEST["edit"]) {
	
	$sql = "SELECT * FROM clientes WHERE id=".$_REQUEST["cod"];
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$nome = $linha["nome"];
	$tipo = $linha["tipo"];

	if($tipo == 1){
		$org = "SELECTED";
	}
	
	if($tipo == 2){
		$prof = "SELECTED";
	}
}

// --- INICIO Efetuando o cadastro
if ($_REQUEST['alt']) {
	
	// Varificacao de campos
	$ok = 1;
	
	$cod = $_REQUEST["cod"];
	
	// cliente 
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
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


		
	if ($_FILES[img][name]){	
		
	if	($_FILES[img][name])	{	
			// Redimencionando Imagens --------------

			//diret�rio destino das imagens dentro da pasta da aplica��o...
			//deve ter permiss�o para escrita chmod(777)...
			$dir = "/home/appwebc/public_html/cms/clientes";
			//recebendo o arquivo multipart vindo do flash...
			$file = $_FILES[img];
			
			$sExt = substr(strrchr($file["name"], "."), 1);
			$sExt = strtolower($sExt);
			$nome_arquivo = time().".".$sExt;
			//finalizando o upload e criando apartir do arquivo temp, multipart, um novo arquivo
			// em nossa pasta de destino. O echo serve para dizer ao flash se deu certo ou n�o...
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $nome_arquivo);
			$filename ="/home/appwebc/public_html/cms/clientes". $nome_arquivo;
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
			} */
			
			//$image = imagecreatefromjpeg($filename);
			$sql = "UPDATE clientes SET nome='$nome',img='$nome_arquivo', tipo='$tipo' WHERE id=$cod";	
		
	

				
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Clientes alterado com sucesso!");
				redireciona("cliente_gerencia.php");
			} 
		}else {
			//  echo 1;
			// Gravando dados no banco
		}
		
	}else{
			$sql = "UPDATE clientes SET  nome='$nome', tipo='$tipo' WHERE id=$cod";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Clientes alterado com sucesso!");
				redireciona("cliente_gerencia.php");
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
				<img src="imagens/barra_altera_cliente.gif" alt="Altera��o de Clientes" title="Altera��o de Clientes" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cliente_gerencia_alt.php?alt=1&cod=<?=$_REQUEST["cod"]?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo: </span> </div>
						<select name="tipo" class="form_style">
							<option value="1" <?=$org?>>Organiza��es</option>
							<option value="2" <?=$prof?>>Profissionais</option>
						</select>
				</div>
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome do Cliente: </span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Logomarca: </span> </div><input type="file" size="50" name="img"  class="form_style">
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
<?if ($frase) {
	alert($frase);
}?>
</html>