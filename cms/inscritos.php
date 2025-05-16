<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM  inscritos_curso WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Inscrito excluido com sucesso!");
		redireciona("inscritos.php");
	}
	
}
// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
    
    $ok = 1;

	if (!($_POST["razaosocial"] == "")) {
		$razaosocial = $_POST["razaosocial"];
	} else {
		$ok = 0;
	}
	
	
	if (!($_POST["nomefantasia"] == "")) {
		$nomefantasia = $_POST["nomefantasia"];
	} else {
		$ok = 0; 
	}
	
	if (!($_POST["cnpj"] == "")) {
		$cnpj = $_POST["cnpj"];
	} else {
		$ok = 0; 
	}
	
	if (!($_POST["info"] == "")) {
		$info = $_POST["info"];
	}
	

	
    
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou est em branco, tente novamente!");
	} else {
	
			// Gravando dados no banco
			$sql = "INSERT INTO empresas (razaosocial,nomefantasia,cnpj,info) VALUES ('$razaosocial','$nomefantasia','$cnpj','$info')";
			//echo $sql;
			
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Empresa cadastrada com sucesso!");
				redireciona("empresa_gerencia.php");  
			}
		
		
			

		}

  }


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title></title>
<link href="css/css.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="favicon.ico" />
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

	/* CSS for the demo. CSS needed for the scripts are loaded dynamically by the scripts */

	
	#mainContainer{
		width:600px;
		margin:0 auto;
		margin-top:10px;
		border:1px double #000;
		padding:3px;

	}
	#calendarDiv,#calendarDiv2{
		width:240px;
		height:240px;
		float:left;
	}
	.clear{
		clear:both;
	}

</style>
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style>
<script type="text/javascript" src="codigo.js"></script>
<script type="text/javascript" src="js/fl.js"></script>
<script src="sorttable.js"></script>
<script language="JavaScript">
function abrir(URL) {
 
  var width = 550;
  var height = 470;
 
  var left = 99;
  var top = 99;
 
  window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
 
}
</script>
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
				Rela��o de Inscritos
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">ID</td>
						<td align="center">Data Inscri��o</td>
						<td align="center">Nome</td>
						<td align="center">Nome Crach�</td>
						<td align="center">CPF</td>
						<td align="center">RG</td>
						<td align="center">E-mail</td>
						<td align="center">Telefone</td>
						<td align="center">Celular</td>
						<td align="center">Razao</td>
						<td align="center">Cnpj</td>
						<td align="center">P. Contato</td>
						<td align="center">Ações</td>
					</tr>  
					
				<?
					$sql = "
						SELECT
						*,
						DATE_FORMAT( `data_insc` , '%d/%c/%Y %H:%i:%s' ) AS data_insc_format
						FROM
						inscritos_curso
						ORDER BY id
					";
					$result = mysql_query($sql);
					
					while ($linha = mysql_fetch_assoc($result)) {
				
				?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["id"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["data_insc_format"]?> </td>
						<td align="center" ><?=$linha["nome_completo"]?> </td>
						<td align="center" ><?=$linha["nome_cracha"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["cpf"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["rg"]?> </td>
						<td align="center" ><?=$linha["email"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["telfixo"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["celular"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["razao"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["cnpj"]?> </td>
						<td align="center" width="1%" nowrap="nowrap"><?=$linha["pessoas_contato"]?> </td>
						<td align="center" width="1%" nowrap="nowrap">
							<!--
							<a href="empresa_gerencia_alt.php?edit=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
							-->
						<a href="javascript:abrir('barras.php?insc_id=<?=$linha["id"]?>');" target="popup"><img src="imagens/icon_gerar_laudo.gif" alt="Listar"  border="0"></a>
							<a href="inscritos.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir?')" alt="Apagar" border="0"></a></td>
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