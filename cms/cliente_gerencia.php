<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM  clientes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Cliente excluido com sucesso!";
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
	
		// Texto
	if (!($_POST["tipo"] == "")) {
		$tipo = nl2br($_POST["tipo"]);
	} else {
		$ok = 0;
	}


	
	if ($ok) {

		$data =  date("Y-m-d H:i:s");

		
	
		
		if	($_FILES[img][name])	{	
			// Redimencionando Imagens --------------

			//diretório destino das imagens dentro da pasta da aplicação...
			//deve ter permissão para escrita chmod(777)...
			$dir = "/home/appwebc/public_html/cms/clientes";
			//recebendo o arquivo multipart vindo do flash...
			$file = $_FILES[img];
			
			$sExt = substr(strrchr($file["name"], "."), 1);
			$sExt = strtolower($sExt);
			$nome_arquivo = time().".".$sExt;
			//finalizando o upload e criando apartir do arquivo temp, multipart, um novo arquivo
			// em nossa pasta de destino. O echo serve para dizer ao flash se deu certo ou não...
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
			}
			*/
			
		
			
		
	


			// Gravando dados no banco
			$sql = "INSERT INTO clientes (nome,tipo,img) VALUES ('$nome','$tipo','$nome_arquivo')";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {					
				alert("Cliente cadastrado com sucesso!");
				redireciona("cliente_gerencia.php");
			} else {
				alert("Erro ao cadastrar,algum campo incorreto!");
				redireciona("cliente_gerencia.php");
			}
		} else {									
			
		// Gravando dados no banco
			$sql = "INSERT INTO clientes (nome,tipo) VALUES ('$nome','$tipo')";
				
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Cliente cadastrado com sucesso!");
				redireciona("cliente_gerencia.php");
				
			} 	else {
				alert("Cliente não cadastrado , Erro ao no cadastro!");
				redireciona("cliente_gerencia.php");
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
				<img src="imagens/barra_novo_cliente.gif" alt="Cadastro de Clientes" title="Cadastro de Clientes" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="cliente_gerencia.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
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
					<div id="label"> <span class="label_fonte">Nome do Cliente: </span> </div><input type="text" size="50" name="nome" value="<?=$nome?>" class="form_style">
				</div>
				
								
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Logomarca: </span> </div><input type="file" size="50" name="img"  class="form_style">
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
			<div id="info">
				<img src="imagens/barra_gerencia_cliente.gif" alt="Gerenciamento de Clientes" title="Gerenciamento de Clientes" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Cliente</td>
						<td align="center">Tipo</td>
						<td align="center">Logomarca</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM clientes ORDER BY nome,tipo";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["nome"];?></td>
						<td align="center" >
							<?
								if($linha["tipo"] == 1){
									echo "Organizações";
								}
								if($linha["tipo"] == 2){
									echo "Profissionais";
								}
							?>			
						</td>
						<td align="center" width="1%"><img src="clientes/<?=$linha["img"];?>" title="<?=$linha["nome"];?>" alt="<?=$linha["cliente"];?>" width="80"/></td>
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="cliente_gerencia_alt.php?edit=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="cliente_gerencia.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o cliente <?=$linha["nome"];?> ?')" title="Apagar" alt="Apagar" border="0">
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