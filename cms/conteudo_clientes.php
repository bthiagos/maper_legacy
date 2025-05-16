<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM conteudo_clientes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("CLIENTE EXCLUÍDO COM SUCESSO!");
	}
	
}
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["nome"] == "")) {
		$nome = $_POST["nome"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO NOME OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["link"] == "")) {
		$link = $_POST["link"];
	} else {
		$ok = 0;
		$msgErro .= "CAMPO LINK OBRIGATÓRIO".'\n';
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
			$sql = "INSERT INTO conteudo_clientes (nome,foto,link) VALUES ('$nome','$arquivo','$link')";
				
			//echo $sql;
			if (mysql_query($sql)) {
				alert("CLIENTE CADASTRADO COM SUCESSO!");
			} else {
				die("Erro: " . mysql_error());
			}
			
			}else{
				// Gravando dados no banco
				$sql = "INSERT INTO conteudo_clientes (nome,link) VALUES ('$nome','$link')";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("CLIENTE CADASTRADO COM SUCESSO!");
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
				CLIENTES
			</div>
			
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			  	
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Logomarca: </span> </div><input type="file" style="width: 30%;" name="foto" value="<?=$foto?>" class="form_style"> 
				</div>
				
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome: </span> </div><input type="text" style="width: 30%;" name="nome" value="<?=$nome?>" class="form_style"> 
				</div>
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Link para o Site: </span> </div><input type="text" style="width: 30%;" name="link" value="<?=$link?>" class="form_style"> 
				</div>
				
			
					 
					<p align='center'><input style="margin-top: 0px;" type="submit" value="CADASTRAR" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
	
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				

		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
		
		
		<div id="caixa_table" style="margin-top: -30px;">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" width="150">Logomarca</td>
						<td align="center">Nome</td>
						<td align="center">Link</td>
						<td align="center" width="80">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM conteudo_clientes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?php if($linha["foto"] != "") { ?><img src="uploaded/<?=$linha["foto"]?>" width="150" /> <? } else { ?> <img src="../imagens/cliente1.jpg" width="150" /> <? } ?></td>
						<td align="center" ><?=$linha["nome"]?> </td>
						<td align="center" ><?=$linha["link"]?> </td>
						<td align="center" >
							<a href="conteudo_clientes_alt.php?edit=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
							<a href="?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('CONFIRMA ESTA AÇÃO?')" alt="Apagar" border="0"></a></td>
					</tr>
				<?
				}
				?>
				</table>

<div id="info_fim">
	
			</div>
			</div>
	</div>
	
			</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>