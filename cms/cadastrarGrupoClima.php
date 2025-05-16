<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM clima_GrupoEmail WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Grupo excluido com sucesso!";
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	// cliente 
	if (!($_POST["nome"] == "")) {
		$nome  = trim($_POST["nome"]);
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
			$sql = "INSERT INTO clima_GrupoEmail (nome,id_organizacao,logo) VALUES ('$nome','$orga','$nome_arquivo')";
			} else {
			$sql = "INSERT INTO clima_GrupoEmail (nome,id_organizacao) VALUES ('$nome','$orga')";					
			}
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Grupo cadastrado com Sucesso!");
				redireciona("cadastrarGrupoClima.php ");
			} else {
				alert("Erro ao cadastrar,algum campo incorreto!");
				redireciona("cadastrarGrupoClima.php ");
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
				<b>Cadastro de Grupo</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cadastrarGrupoClima.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome do Grupo: </span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
				<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
				<select name="orga" class="form_style">
				<option value="Selecione">Selecione</option>
				<?
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($fabricante == $linha["id"]) {
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
	

				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->			
			
			
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Gerenciamento de Grupo</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Organizacao</td>
						<td align="center">Grupo</td>
						<td align="center">Logo</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT
					clima_GrupoEmail.nome,
					organizacoes.nome AS organizacao,
					clima_GrupoEmail.logo,
					clima_GrupoEmail.id
					FROM
					clima_GrupoEmail
					Inner Join organizacoes ON organizacoes.id = clima_GrupoEmail.id_organizacao
					 ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["organizacao"];?></td>						
						<td align="center" ><?=$linha["nome"];?></td>
						<td align="center" width="1%"><img src="logoEmpresa/<?=$linha["logo"];?>" alt="<?=$linha["nome"];?>" width="150"/></td>						
						<td align="center" width="1%" nowrap>
													
							<a href="cadastrarGrupoClima_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
								
							<!-- Icone de Exclusao -->
							<a href="cadastrarGrupoClima.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o Grupo <?=$linha["nome"];?> ?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
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