<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
if ($_REQUEST['apagar']) {
	
	$tipo = $_REQUEST['apagar'];
	$sql2 = "SELECT * FROM ce_letter WHERE codigo=".$_REQUEST['cod'];
	$resulta = mysql_query($sql2);
	$linha = mysql_fetch_assoc($resulta);
	$arq = $linha["arq"];
	
	$sql = "DELETE FROM ce_letter WHERE codigo=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Newsletter excluida com sucesso!");
	}
	
	if (($_REQUEST['apagar'] == 2) || ($_REQUEST['apagar'] == 3)) {
		$tipo = $_REQUEST['apagar'];
		
		if ($tipo == 2) {
			@unlink("letter/img/$arq");
		}
		
		if ($tipo == 3) {
			@unlink("letter/html/$arq");
		}

		
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	
	
	// Varificacao de campos
	$ok = 1;
	
	// titulo 
	if (!($_POST["titulo"] == "")) {
		$titulo  = $_POST["titulo"];
	} else {
		$ok = 0;
	}
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
	} else {
	
		 //RECEBE O ARQUIVO
		 $arqName = time().".htm";
		 $arqTemp = $_FILES[arquivo][tmp_name];
		 if(move_uploaded_file($arqTemp,"letter/html/".$arqName)) {
		 //CONECTA AO FTP
		
			$sql = "INSERT INTO ce_letter (titulo,tipo,arq) values ('$titulo',3,'$arqName')";
			// Confirmacao de insert

				if (mysql_query($sql)) {
					alert("Newsletter cadastrada com sucesso!");
					redireciona("letter_cadastro_html.php");
				} // IF QUERY

		}// IF OK
		}


	}// IF REQUEST
	

// --- FIM    Efetuando o cadastro

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title></title>
<script language="javascript">
function pergunta(){
	if (document.enviarLetter.grupo.selectedIndex != 0 && confirm('Deseja realmente enviar os emails?')){
       document.enviarLetter.submit();
    }
} 
</script>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1"> 

<!-- *** QuickMenu copyright (c) 2007, OpenCube Inc. All Rights Reserved.

	-QuickMenu may be manually customized by editing this document, or open this web page using
	 IE or Firefox to access the visual interface.

-->


<!-- QuickMenu Noscript Support [Keep in head for full validation!] -->
<noscript><style type="text/css">.qmmc {width:200px !important;height:200px !important;overflow:scroll;}.qmmc div {position:relative !important;visibility:visible !important;}.qmmc a {float:none !important;white-space:normal !important;}</style></noscript>


<!--%%%%%%%%%%%% QuickMenu Styles [Keep in head for full validation!] %%%%%%%%%%%-->
<style type="text/css">


/*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;}.qmmc {position:relative;}.qmmc a {float:left;display:block;white-space:nowrap;}.qmmc div a {float:none;}.qmsh div a{float:left;}.qmmc div {visibility:hidden;position:absolute;}

/*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/



	/* QuickMenu 0 */

	/*"""""""" (MAIN) Container""""""""*/	
	#qm0	
	{	
		background-color:transparent;
	}


	/*"""""""" (MAIN) Items""""""""*/	
	#qm0 a	
	{	
		padding:5px 40px 5px 8px;
		background-color:#FFFFFF;
		color:#000000;
		font-family:Arial;
		font-size:0.8em;
		text-decoration:none;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (MAIN) Hover State""""""""*/	
	#qm0 a:hover	
	{	
		background-color:#FFFFFF;
	}


	/*"""""""" (MAIN) Parent items""""""""*/	
	#qm0 .qmparent	
	{	
	}


	/*"""""""" (MAIN) Active State""""""""*/	
	body #qm0 .qmactive, body #qm0 .qmactive:hover	
	{	
		background-color:#E6E6E6;
		text-decoration:underline;
	}


	/*"""""""" (SUB) Container""""""""*/	
	#qm0 div	
	{	
		padding:5px;
		margin:-1px 0px 0px 0px;
		background-color:#E6E6E6;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (SUB) Items""""""""*/	
	#qm0 div a	
	{	
		padding:2px 40px 2px 5px;
		background-color:transparent;
		border-width:0px;
		border-style:none;
		border-color:#000000;
	}


	/*"""""""" (SUB) Hover State""""""""*/	
	#qm0 div a:hover	
	{	
		text-decoration:underline;
	}


	/*"""""""" (SUB) Parent items""""""""*/	
	#qm0 div .qmparent	
	{	
	}


	/*"""""""" (SUB) Active State""""""""*/	
	body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
	{	
		background-color:#FFFFFF;
	}


</style>
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style>
<script type="text/javascript" src="codigo.js"></script>
<script src="sorttable.js"></script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "simple"
});
</script>

</style>
</head>

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
				<img src="imagens/cadastro_tipoHtml.gif" alt="Cadastro de Newsletter" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="letter_cadastro_html.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Titulo: </span> </div><input type="text" size="50" name="titulo" value="<?=$titulo?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Arquivo HTML: </span> </div><input type="file" size="50" name="arquivo" class="form_style">
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
				<img src="imagens/gerenciamento_tipoHtml.gif" alt="Gerenciamento de Newsletters" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Titulo</td>
						<td align="center" nowrap>Disparar para:</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>	
					</tr>
				
					
			<?
				$sql = "SELECT * FROM ce_letter WHERE tipo=3 ORDER BY codigo";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["titulo"]?></td>
						<td align="center" width="2%" >
						<form action="letter_dispara.php?cod=<?=$linha["codigo"]?>" method="POST" name="enviarLetter<?=$linha["codigo"]?>">
						<select name="grupo" class="form_style">
					<option>Selecione</option>
					
					
					<?
					
					$sql2 = "SELECT * FROM  ce_grupos_contatos ORDER BY grupo";
					$result2 = mysql_query($sql2);
					
					while ($linha2 = mysql_fetch_assoc($result2)) {
					?>
						<option value="<?=$linha2["codigo"]?>"><?=$linha2["grupo"]?></option>
					<?
						
						
						
					}
					
					?>
					</select><input type="submit" onclick="javascript: return confirm('Deseja enviar a Newsletter?')" value="Enviar"></form>
						
						
						</td>
						<td align="center" >
						
						<a href="letter/html/<?=$linha["arq"]?>" target="_blank"><img src="imagens/icon_ver.gif" alt="Visualizar" title="Visualizar" border="0"></a>
						
						<a href="letter_cadastro_html.php?apagar=<?=$linha["tipo"]?>&cod=<?=$linha["codigo"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Newsletter?')" alt="Apagar" border="0"></a></td>
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
</html>