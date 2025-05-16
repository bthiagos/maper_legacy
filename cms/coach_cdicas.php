<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM coach_dicas WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("DICA EXCLUÍDA COM SUCESSO!");
	}
	
}
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
			$sql = "INSERT INTO coach_dicas (titulo,subtitulo,descricao,conteudo,foto) 
			VALUES ('$titulo','$subtitulo','$descricao','$conteudo','$arquivo')";
				
			//echo $sql;
			if (mysql_query($sql)) {
				alert("DICA CADASTRADA COM SUCESSO!");
				redireciona("coach_cdicas.php");
			} else {
				die("Erro: " . mysql_error());
			}
			
			}else{
				// Gravando dados no banco
				$sql = "INSERT INTO coach_dicas (titulo,subtitulo,descricao,conteudo) 
			VALUES ('$titulo','$subtitulo','$descricao','$conteudo')";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("EXEMPLO CADASTRADO COM SUCESSO!");
					redireciona("coach_cdicas.php");
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
				COACH - Dicas
			</div>
			
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1" method="post" name="cadastro">
			
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
		
		
		<div id="caixa_table" style="margin-top: -30px;">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Título</td>
						<td align="center">Subtítulo</td>
						<td align="center">Descrição</td>
						<td align="center">Conteúdo</td>
						<td align="center">Foto</td>

						<td align="center" width="80">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM coach_dicas";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$linha["titulo"]?> </td>
						<td align="center" ><?=$linha["subtitulo"]?> </td>
						<td align="center" ><?=$linha["descricao"]?> </td>
						<td align="center" ><?=$linha["conteudo"]?> </td>
						
						<td align="center" width="150" ><? if($linha["foto"] != "") { ?><img src="uploaded/<?=$linha["foto"]?>" width="150"><? }else{ ?> Sem foto <? } ?></td>
						<td align="center" >
							<a href="coach_cdicas_alt.php?edit=1&id=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
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