<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM coach_videos WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("VÍDEO EXCLUÍDO COM SUCESSO!");
	}
	
}
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra'])  {
	
	// Varificacao de campos
	$ok = 1;
	
	if (!($_POST["titulo"] == "")) {
		$titulo = addslashes($_POST["titulo"]);
	} else {
		$ok = 0;
		$msgErro .= "CAMPO TÍTULO OBRIGATÓRIO".'\n';
	}
	

	
	if (!($_POST["descricao"] == "")) {
		$descricao =  addslashes($_POST["descricao"]);
	} else {
		$ok = 0;
		$msgErro .= "CAMPO DESCRIÇÃO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["video"] == "")) {
		$video = $_POST["video"];
	} else {
		$ok = 0; 
		$msgErro .= "CAMPO VÍDEO OBRIGATÓRIO".'\n';
	}
	


			// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msgErro);
	} else {

				// Gravando dados no banco
				$sql = "INSERT INTO coach_videos (titulo,descricao,video)
			VALUES ('$titulo','$descricao','$video')";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("VÍDEO CADASTRADO COM SUCESSO!");
					redireciona("coach_cvideos.php");
				} else {
					die(mysql_error());
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
				COACH - Vídeos
			</div>
			
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form enctype="multipart/form-data" action="?cadastra=1" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			  	
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Título: </span> </div><input type="text" style="width: 30%;" name="titulo" value="<?=$titulo?>" class="form_style"> 
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Descrição: </span> </div><textarea style="width: 40%; height: 70px;" name="descricao"  class="form_style"><?=$descricao?></textarea>
				</div>
				
			
				<div id='linha_form' style='margin-top: 60px;'>
					<div id='label'> <span class='label_fonte'>Vídeo: </span> </div><input type='text' style='width: 30%' name='video' value='<?=$video?>'  class='form_style'> 
				</div>
			
			
					 
					<p align='center'><input style="margin-top: 10px;"  type="submit" value="CADASTRAR" class="form_style"></p>
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
						<td align="center">Descrição</td>
						<td align="center" width="425">Vídeo</td>
				

						<td align="center" width="80">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM coach_videos";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$linha["titulo"]?> </td>
						
						<td align="center" ><?=$linha["descricao"]?> </td>
						<td align="center" ><?=$linha["video"]?> </td>
						
						<td align="center" >
							<a href="coach_cvideos_alt.php?edit=1&id=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
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