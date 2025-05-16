<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?


// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
$id_perguntas =	$_REQUEST['cod'];
	
	$sql = "DELETE FROM pesquisa_alternativas WHERE id=".$_REQUEST['id'];
	if (mysql_query($sql)) {
		$frase = "Alternativas excluido com sucesso!";
		alert($frase);
		redireciona("pesquisa_alternativas.php?cod=$id_perguntas");
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
		$texto_aberto  = "";
		
		
		$outras = "";
		
	}	
	/// FIM QUESTAO ABERTA
	
	
	/// QUESTAO FECHADA
	if($forma_pergunta == 2){		
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
	} else {
		
		//VERIFICANDO SE EXISTE GRUPO_PERGUNTA
			// FORMA DA PERGUNTA ABERTA OU FECHADA
	if (!($_POST["grupo_pergunta"] == "")) {
		//$grupo_pergunta  = $_POST["grupo_pergunta"];
		$grupo_pergunta_separadas = explode(",",$_POST["grupo_pergunta"]);
		
		///pegando o CODIGO PESQUISA
		$id_pesquisa = codigo_pesquisa($id_perguntas);
		
		//SQL COM TODAS AS PERGUNTAS DA PESQUISA 
		$sql_pesquisa = "SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = '$id_pesquisa' ORDER BY id";
		$result_pesquisa = mysql_query($sql_pesquisa);
		 //contador array grupo_pergunta
		$i=1; // contador com o numero da pergunta
			
				
		while($linha_pesquisa = mysql_fetch_assoc($result_pesquisa)){
		
			for($y=0;$y<=count($grupo_pergunta_separadas);$y++){
				
				if($grupo_pergunta_separadas[$y] == $i){
					unset($grupo_pergunta_separadas[$y]);
					$grupo_pergunta_separadas[$y] = "0000";
					$id_perguntas2 = $linha_pesquisa["id"];
					
					//VERIFICA SE EXISTE ALGUMA ALTERNATIVA PARA A PERGUNTA
					$sql_pergunta = "SELECT * FROM pesquisa_alternativas WHERE id_perguntas = $id_perguntas2";
					$result_pergunta = mysql_query($sql_pergunta);
						if(mysql_num_rows($result_pergunta)>0){
									
						//sSE NAO EXISTIR			
						}else{
						$sql = "INSERT INTO pesquisa_alternativas (id_perguntas,formato_perguntas,texto_aberta,alternativas,outras) VALUES ('$id_perguntas2','$forma_pergunta','$texto_aberto','$alternativas','$outras')";
						
							
						}
				}
			}		
			mysql_query($sql);
			$i++;
		}
	} 
		
		
		//FIM VERIFICANDO SE EXISTE GRUPO_PERGUNTA
		
		// Gravando dados no banco
			$sql = "INSERT INTO pesquisa_alternativas (id_perguntas,formato_perguntas,texto_aberta,alternativas,outras) VALUES ('$id_perguntas','$forma_pergunta','$texto_aberto','$alternativas','$outras')";
				
			//echo $sql;
		//	break;
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Alternativa cadastrado com sucesso!");
				redireciona("pesquisa_alternativas.php?cod=$id_perguntas");
				
			} 	else {
				alert("Alternativa não cadastrado , Erro ao no cadastro!");
				redireciona("pesquisa_alternativas.php?cod=$id_perguntas");
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

var divIdName = "eventDate"+num+"Div";
var newdiv = document.createElement('div');
newdiv.setAttribute("id",divIdName);
newdiv.innerHTML = "<div id=\"linha_form_auto\"><div id=\"label\"> <span class=\"label_fonte\">Alternativa "+num+"*</span> </div><input type=\"text\" size=\"50\"  name=\"alternativa"+num+"  /></div>";


ni.appendChild(newdiv);

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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Cadastro das Alternativas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pesquisa_alternativas.php?cadastra=1&cod=<?=$id_perguntas?>" method="post" name="form1">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">		
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Grupo de pergunta : </span> </div><input type="text" size="60" name="grupo_pergunta" onKeyUp="javascript:somente_numero(this);"> <span class="label_fonte"><b>OPCIONAL</b>.  <i> (Exemplo: 1,3,4,8)</i></span>
				</div>
				
				<div id="linha_form_auto" style="margin-top:15px;">
					<div id="label"> <span class="label_fonte">Formato da pergunta*</span> </div><input type="radio" onclick="OcultarDivFechada();AparecerDivAberta();" name="forma_pergunta" value="1">&nbsp;<span class="label_fonte">Aberta</span>&nbsp;<input type="radio" onclick="OcultarDivAberta();AparecerDivFechada();" name="forma_pergunta" value="2">&nbsp;<span class="label_fonte">Fechada</span>
				</div>
				
				<div id="linha_form_auto"> 
				<div id="aberta" style="display: none;">
				
					<!--<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Texto*</span> </div><textarea rows="2" cols="60" name="alternativa"></textarea>
					</div>-->
				
				</div>
				</div>
				
				
				
				<div id="linha_form_auto"> 
				<div id="fechada" style="display: none;">		
				
						<div id="linha_form_auto"> 
						<div id="label"><input type="button" onClick="addEvent();" value="Adicionar Alternativa" class="form_style"> </div>&nbsp;
					</div>
						
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Alternativa 1*</span> </div><input type="text" name="alternativa1" size="50" />
					</div>
					
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Alternativa 2*</span> </div><input type="text" name="alternativa2" size="50"/>
					</div>
					<input type="hidden" value="2" id="theValue" name="valor"/>
					<div id="eventDates"> </div>
					
				
					
					<div id="linha_form_auto">
						<div id="label"> <span class="label_fonte">Informa&ccedil;&otilde;es adicionais </span> </div><input type="checkbox" name="outras" value="1"/>
					</div>
				</div>
				</div>
					
					<?
					//// VERIFICANDO SE EXISTE ALGUM REGISTRO PARA PERGUNTA 
						$sql_pergunta = "SELECT * FROM pesquisa_alternativas WHERE id_perguntas = $id_perguntas";
						$result_pergunta = mysql_query($sql_pergunta);
						if(mysql_num_rows($result_pergunta)>0){?>
							
							<p align="center"><span class="label_fonte">Uma Alternativa ja foi cadastra.Para efetuar um novo cadastra basta excluir a alternativa cadastrada.</span> </p>
						<?}else{?>
							<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
							
					<?	}
					////FIM 
					?>
					
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
				<b>Gerenciamento das Alternativas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
			
			
				
				
			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Formato da Pergunta</td>
						<td align="center">Alternativas</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM pesquisa_alternativas WHERE id_perguntas = $id_perguntas  ORDER BY id DESC";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" >
							<?
								
								if($linha["formato_perguntas"] == "1"){
									echo "Aberta";
								}
								
								if($linha["formato_perguntas"] == "2"){
									echo "Fechada";
								}				
								
							
							?>					
						
						</td>
						
						<td align="center" >
							<?	
								if($linha["formato_perguntas"] == "1"){
									
									echo $linha["texto_aberta"];
								}
								
								if($linha["formato_perguntas"] == "2"){
								
									$alternativas_separadas = explode("|",$linha["alternativas"]);
									$alternativas_juntas = implode("<br>",$alternativas_separadas);
									echo $alternativas_juntas;
								}
							?>
						</td>
						
						<td align="center" >

						<a href="pesquisa_alternativas_alt.php?edit=1&cod=<?=$id_perguntas?>&id=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>

						<a href="pesquisa_alternativas.php?apagar=1&cod=<?=$id_perguntas?>&id=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir as alternativas?')" alt="Apagar" border="0"></a></td>
					</tr>
				<?
				}
				?>
				</table>
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte"><a href="pesquisa_perguntas.php?pesquisa=1&id_pesquisa=<?=$id_perguntas?>" style="font-family: arial; font-size: 12px; color: #666666">Voltar</a> </span> </div>
				</div>
				<br/>

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