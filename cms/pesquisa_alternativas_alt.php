<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
// --- INICIO Efetuando a EXCLUSAO DA ALTERNATIVA
if($_REQUEST["apagar"]){
	
	$id_perguntas =	$_REQUEST['cod'];
	$id_alternativa =	$_REQUEST['id'];
	$conteudoAlternativa =	($_REQUEST['alt'] -1);
	
	$sql = "SELECT * FROM pesquisa_alternativas WHERE id=$id_alternativa";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$alternativas = explode("|",$linha["alternativas"]);
	
	
	for($i=0;$i<count($alternativas);$i++){
		if($i==$conteudoAlternativa){
			unset($alternativas[$i]);
		}
	}
	$alternativas = implode("|",$alternativas);	
	$sql = "UPDATE pesquisa_alternativas SET alternativas='$alternativas' WHERE id= $id_alternativa";
	mysql_query($sql);
}

// --- FIM Efeutando a exclusao da alternativa

// --- INICIO Efetuando a EDICAO
if ($_REQUEST['edit']) {
	
$id_perguntas =	$_REQUEST['cod'];
$id_alternativa =	$_REQUEST['id'];
	
	$sql = "SELECT * FROM pesquisa_alternativas WHERE id=$id_alternativa";
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	
	$formato_pergunta = $linha["formato_perguntas"];
	
	if($formato_pergunta == 1){
		$texto_aberta = $linha["texto_aberta"];
		$aberta = " CHECKED ";
		$fechada = " ";
		$onload = "onload=\"AparecerDivAberta();\"";
	}
	
	if($formato_pergunta == 2){
		$texto_aberta = $linha["texto_aberta"];
		if($linha["outras"] == 1){
			$outras = "CHECKED";
		}else{
			$outras = "";
		}
		$aberta = " ";
		$fechada = " CHECKED ";
		$onload = "onload=\"AparecerDivFechada();\"";
		$alternativas = explode("|",$linha["alternativas"]);
		$quant_alternativas = count($alternativas);		
	}	
}

// --- FIM    Efetuando a exlcusao


if(!$_REQUEST["cod"]){
	echo "<script>history.go(-1);</script>";
}else{
	$id_perguntas = $_REQUEST["cod"];
}

?>
<?

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	$id_perguntas = $_REQUEST["cod"];
	$id_alternativa =	$_REQUEST['id'];
	
	// Varificacao de campos
	$ok = 1;
	
	
	// FORMA DA PERGUNTA ABERTA OU FECHADA
	if (!($_POST["forma_pergunta"] == "")) {
		$forma_pergunta  = $_POST["forma_pergunta"];
	} else {
		$ok = 0;
	}
	
	/// QUESTAO ABERTA
	if($forma_pergunta == 1){
		if (!($_POST["alternativa"] == "")) {
		$texto_aberto  = trim($_POST["alternativa"]);
		} else {
			$ok = 0;
		}
		
		$outras = "";
		$alternativas = "";
		
	}	
	/// FIM QUESTAO ABERTA
	
	
	/// QUESTAO FECHADA
	if($forma_pergunta == 2){	
		
		$texto_aberto="";
			
		//Qunatidade de ALTERNATIVAS
		$quantidade_alt = $_POST["valor"];
		
		for($i=1;$i<=$quantidade_alt;$i++){
			$alternativa = "alternativa".$i;
			
			if($_POST[$alternativa] != ""){
				$alternativas .= $_POST[$alternativa]."|";
			}else{
				$ok=0;
			}			
		}		
		
		if($_POST["outras"]){
		
		$alternativas .= "Informações Adicionais";
			$outras = "1";
			} else {
			$outras = "";
		}
		
	}
	/// FIM QUESTAO FECHADA	WS	
	
	
	

	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		redireciona("pesquisa_alternativas_alt.php?edit=1&cod=$id_perguntas&id=$id_alternativa");
	} else {
		
	
		
		//FIM VERIFICANDO SE EXISTE GRUPO_PERGUNTA
		
		// Gravando dados no banco
			$sql = "UPDATE pesquisa_alternativas SET id_perguntas='$id_perguntas',formato_perguntas='$forma_pergunta',texto_aberta='$texto_aberto',alternativas='$alternativas',outras='$outras' WHERE id= $id_alternativa";
				
			//echo $sql;
		//	break;
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Alternativa alterada com sucesso!");
				redireciona("pesquisa_alternativas.php?cod=$id_perguntas");
				
			}else{
				alert("Alternativa não cadastrado , Erro ao no cadastro!");
				redireciona("pesquisa_alternativas_alt.php?edit=1&cod=$id_perguntas&id=$id_alternativa");
			}
			
		}
		

	}
	


// --- FIM    Efetuando o cadastro

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title><?=titulo_janela();?></title>
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
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript">  
 
 function somente_numero(campo){  
 var digits="0123456789,"  
 var campo_temp   
     for (var i=0;i<campo.value.length;i++){  
         campo_temp=campo.value.substring(i,i+1)   
         if (digits.indexOf(campo_temp)==-1){  
             campo.value = campo.value.substring(0,i);  
         }  
     }  
 }  
   

 
 </script>
 
<script language="javascript">
function GetXMLHttp() {

    if(navigator.appName == "Microsoft Internet Explorer") {

        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

    }

    else {

        xmlHttp = new XMLHttpRequest();

    }

    return xmlHttp;

}


var xmlRequest = GetXMLHttp();


function abrirPag(valor){

var url = valor;


xmlRequest.onreadystatechange = mudancaEstado;

xmlRequest.open("GET",url,true);

xmlRequest.send(null);

/*
if (xmlRequest.readyState == 1) {

document.getElementById("conteudo_mostrar").innerHTML = "CARREGANDO";

}*/


return url;

}


function mudancaEstado(){

if (xmlRequest.readyState == 4){

document.getElementById("conteudo_mostrar").innerHTML = xmlRequest.responseText;

}

}






 // atribuir o nome da div que quer mostrar e ocultar  
 
 function AparecerDivAberta(){ // função aparecer  
 	var div = "aberta";  
     document.getElementById(div).style.display = "block";  
    // usamos o style.display para manupular o css da div e mostrar ela  
}  
 
function OcultarDivAberta(){  // função ocultar  
	var div = "aberta"; 
     document.getElementById(div).style.display = "none";  
     // usamos o style.display para manupular o css da div e ocultar ela  
}


function AparecerDivFechada(){ // função aparecer  
 	var div = "fechada";  
     document.getElementById(div).style.display = "block";  
    // usamos o style.display para manupular o css da div e mostrar ela  
}  
 
function OcultarDivFechada(){  // função ocultar  
	var div = "fechada"; 
     document.getElementById(div).style.display = "none";  
     // usamos o style.display para manupular o css da div e ocultar ela  
}

var mainDivName = 'eventDates';

function addEvent()
{
	
var ni = document.getElementById(mainDivName);

var numi = document.getElementById('theValue');
var num = (document.getElementById("theValue").value -1)+ 2;
numi.value = num;
var nomealternativa = "alternativa"+num;

var divIdName = "eventDate"+num+"Div";
var newdiv = document.createElement('div');
newdiv.setAttribute("id",divIdName);
newdiv.innerHTML = "<div id=\"linha_form_auto\"><div id=\"label\"> <span class=\"label_fonte\">Alternativa "+num+"*</span> </div><input type=\"text\" name="+nomealternativa+" /></div>";


ni.appendChild(newdiv);

}

function addEvent2(alternativa,codalt,codpergunta)
{
	
	
var ni = document.getElementById(mainDivName);

var numi = document.getElementById('theValue');
var num = (document.getElementById('theValue').value -1)+ 2;
numi.value = num;
var nomealternativa = "alternativa"+num;
var divIdName = "eventDate"+num+"Div";
var newdiv = document.createElement('div');
newdiv.setAttribute("id","eventDate"+num+"Div");
newdiv.innerHTML = "<div id=\"linha_form_auto\"><div id=\"label\"><span class=\"label_fonte\">Alternativa "+num+"*</span></div><input type=\"text\" name="+nomealternativa+"  value="+alternativa+"  /><a href=\"pesquisa_alternativas_alt.php?edit=1&apagar=1&cod="+codpergunta+"&id="+codalt+"&alt="+num+"\"  style=\"text-decoration: none;\">&nbsp;<img src=\"imagens/icon_apagar.gif\"  onclick=\"javascript: return confirm('Deseja realmente excluir a alternativa ?')\" title=\"Apagar\" alt=\"Apagar\" border=\"0\"></a></div>";

ni.appendChild(newdiv);

}

</script>

</head>

<body <?=$onload?>>

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
				<b>Cadastro das Alternativas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pesquisa_alternativas_alt.php?cadastra=1&cod=<?=$id_perguntas?>&id=<?=$id_alternativa?>" method="post" name="form1">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">		
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Formato da pergunta*</span> </div><input type="radio" onclick="OcultarDivFechada();AparecerDivAberta();" name="forma_pergunta" value="1" <?=$aberta?>>&nbsp;<span class="label_fonte">Aberta</span>&nbsp;<input type="radio" onclick="OcultarDivAberta();AparecerDivFechada();" name="forma_pergunta" value="2" <?=$fechada?>>&nbsp;<span class="label_fonte">Fechada</span>
				</div>
				
				<div id="aberta" style="display: none;">
				
					<!--<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Texto*</span> </div><textarea rows="2" cols="60" name="alternativa"><?=$texto_aberta?></textarea>
					</div>-->
				
				</div>
				
				
				
				
				<div id="fechada" style="display: none;">		
				
					<div id="linha_form_auto"> 
						<div id="label"><input type="button" onClick="addEvent();" value="Adicionar Alternativa" class="form_style"> </div>&nbsp;
					</div>
					
					
						
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Alternativa 1*</span> </div><input type="text" name="alternativa1" value="<?=$alternativas[0]?>" /> 						<!-- Icone de Exclusao -->
							<a href="pesquisa_alternativas_alt.php?edit=1&apagar=1&cod=<?=$id_perguntas?>&id=<?=$id_alternativa?>&alt=1">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a alternativa ?')" title="Apagar" alt="Apagar" border="0">
							</a>
					</div>
					
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Alternativa 2*</span> </div><input type="text" name="alternativa2" value="<?=$alternativas[1]?>"/>
						<a href="pesquisa_alternativas_alt.php?edit=1&apagar=1&cod=<?=$id_perguntas?>&id=<?=$id_alternativa?>&alt=2">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a alternativa ?')" title="Apagar" alt="Apagar" border="0">
							</a>
					</div>
					<input type="hidden" value="2" id="theValue" name="valor"/>
					<div id="eventDates"> </div>
					
					<?
						if($formato_pergunta == 2){
							if($quant_alternativas != 2){
								$a=0;
								for($i=2;$i<$quant_alternativas;$i++){
								$a = $quant_alternativas-1;
								
									if($a == $i){
										
										if($outras != "CHECKED"){											
											//$valor_alternativa=$alternativas[$i];
											//echo "<script>addEvent2('$valor_alternativa')</script>";
										}else{
											
										}
									}else{
										//$valor_alternativa=$alternativas[$i];
										$valor_alternativa=str_ireplace(" ","&nbsp;",$alternativas[$i]);
										
										echo "<script>addEvent2('$valor_alternativa','$id_alternativa','$id_perguntas');</script>";
									}
								
								}
							
							}
						}
					
					?>
					
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Informa&ccedil;&otilde;es adicionais </span> </div><input type="checkbox" name="outras" value="1" <?=$outras?>/>
					</div>
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
</html>