<?php
include("conn.php");
include("logon.php");
include("library.php");

if ($_REQUEST["edit"]) {
	
	$sql = "SELECT * FROM organizacoes WHERE id=".$_REQUEST["cod"];
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);

    $nome = $linha["nome"];
    $creditos = $linha["creditos"];
	$pg_cliente = $linha["pg_cliente"];
	$pg_organizacao = $linha["pg_organizacao"];

	if($pg_cliente == 1){
		$clinte_check = "checked";
	}
	
	if($pg_organizacao == 1){
		$organizacao_check = "checked";
	}
	
}

// --- INICIO Efetuando o cadastro
if ($_REQUEST['alt']) {
	
	// Varificacao de campos
	$ok = 1;
	
	$cod = $_REQUEST["cod"];
	
	// cliente 
	if (!($_POST["nome"] == "") && ! ($_POST["creditos"] == "")) {
        $nome  = trim($_POST["nome"]);
        $creditos  = trim($_POST["creditos"]);
	} else {
		$ok = 0;
	}

	$clientes = $_POST["clientes"];
	$organizacao = $_POST["organizacao"];

	
	if ($ok) {


		
	if ($_FILES[img][name]){	
		
	if	($_FILES[img][name])	{	
			// Redimencionando Imagens --------------

			//diretório destino das imagens dentro da pasta da aplicação...
			//deve ter permissão para escrita chmod(777)...
			$dir = "/home/appweb/public_html/cms/clientes";
			//recebendo o arquivo multipart vindo do flash...
			$file = $_FILES[img];
			
			$sExt = substr(strrchr($file["name"], "."), 1);
			$sExt = strtolower($sExt);
			$nome_arquivo = time().".".$sExt;
			//finalizando o upload e criando apartir do arquivo temp, multipart, um novo arquivo
			// em nossa pasta de destino. O echo serve para dizer ao flash se deu certo ou não...
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $nome_arquivo);
			$filename ="/home/appweb/public_html/cms/clientes". $nome_arquivo;
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
			$sql = "UPDATE organizacoes SET nome='$nome',img='$nome_arquivo', pg_cliente='$clientes', pg_organizacao='$organizacao' WHERE id=$cod";	
		
	

				
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Clientes alterado com sucesso!");
				redireciona("cadastroEmpresa.php");
			} 
		}else {
			//  echo 1;
			// Gravando dados no banco
		}
		
	}else{
			$sql = "UPDATE organizacoes SET nome='$nome', creditos='$creditos',  pg_cliente='$clientes', pg_organizacao='$organizacao' WHERE id=$cod";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Clientes alterado com sucesso!");
				redireciona("cadastroEmpresa.php");
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
				<img src="imagens/barra_altera_cliente.gif" alt="Alteração de Clientes" title="Alteração de Clientes" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastroEmpresa_alt.php?alt=1&cod=<?=$_REQUEST["cod"]?>" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
				
						
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome do Cliente: </span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>

                <div id="linha_form">
                    <div id="label"> <span class="label_fonte">Créditos do Cliente: </span> </div><input type="text" size="50" name="creditos" value="<?=$creditos?>" class="form_style">
                </div>
				
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Logomarca: </span> </div><input type="file" size="50" name="img"  class="form_style">
				</div>
				
						
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Status: </span> </div><br />
					<p>
					<input type="checkbox" value="1" name="clientes" <?=$clinte_check?> /> <span class="label_fonte">Disponível na aba "Clientes"</span><br />
					<input type="checkbox" value="1" name="organizacao" <?=$organizacao_check?>/> <span class="label_fonte">Disponível na lista de "Organizações"</span>
					</p>
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