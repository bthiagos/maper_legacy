
<?php include("library.php"); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avalia��o de Potencial e Perfil Profissional</title>
<style type="text/css">
.style17 {font-family: Arial; font-size: 8px; font-weight: bold; }
.style18 {font-family: Helvetica; font-size: 8px; }
body,td,th {
	font-family: Arial, Helvetica, serif;
	font-size: 8px;
}
body {
	margin-left: 8px;
	margin-top: 0px;
	margin-right: 10px;
	margin-bottom: 0px;
}
.folha {
    page-break-after: always;
}



</style>
</head>
<body>


<!------    PLANEJAMENTO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    		<h1> 1	- Planejamento</h4>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia o grau de identifica��o do indiv�duo com a atividade de planejar. Entende-se planejar com a��o de criar recursos para se atingir os objetivos, definindo <br /> as linhas de a��o, prazos e meios.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	<? 
	$zero = $umdois = $tres = $sete = $oitonove = $dez  = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==4 or $totaCompetencias[$a][0]==5 or $totaCompetencias[$a][0]==6){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==0){
			$zero++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==1 or $totaCompetencias[$a][0] ==2){
			$umdois++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==3){
			$tres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==7){
			$sete++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==8 or $totaCompetencias[$a][0] ==9){
			$oitonove++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==10){
			$dez++;
		}
	}
	
	////$url3 = "http://www.appweb.com.br/cms/planejamento.php?media=$media&zero=$zero&umdois=$umdois&tres=$tres&sete=$sete&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
	//executa_url("$url3");
	
	?>
	<p>
	<img src="graficos_grupos/planejamento.png" border="0">

	</p>
	
	</td>
</tr>
</table>
</p>
<!------    PLANEJAMENTO     ------>

<div class="folha">&nbsp;</div>


<!------    ORGANIZA�AO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    		<h1> 2 - Organiza��o</h4>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia a capacidade que o indiv�duo possui com aspectos organizativos e com a administra��o do tempo
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	<? 
	$zeroumdois = $tres = $sete = $oitonovedez = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==4 or $totaCompetencias[$a][1]==5 or $totaCompetencias[$a][1]==6){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==0 or $totaCompetencias[$a][1] ==1 or $totaCompetencias[$a][1] ==2){
			$zeroumdois++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==3){
			$tres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==7){
			$sete++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==8 or $totaCompetencias[$a][1] ==9 or $totaCompetencias[$a][1] ==10){
			$oitonovedez++;
		}
	}
			
	//$url3 = "http://www.appweb.com.br/cms/organizacao.php?media=$media&zeroumdois=$zeroumdois&tres=$tres&sete=$sete&oitonovedez=$oitonovedez&nPessoas=$nPessoas";
	//echo $url3;
	//executa_url("$url3");
	
	?>
	<p>
	<img src="graficos_grupos/organizacao.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    ORGANIZA�AO     ------>

<div class="folha">&nbsp;</div>


<!------    ACOMPANHAMENTO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    		<h1> 3 - Acompanhamento</h4>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia a capacidade do indiv�duo para acompanhar e promover o desenvolvimento de sua equipe, atrav�s de treinamentos, fornecimento de informa��es, dados <br /> e orienta��es.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	<? 
	
	$zeroumdoistres = $quatro = $cinco = $oito = $novedez = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] == 6 or $totaCompetencias[$a][2]== 7){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==0 or $totaCompetencias[$a][2]==1 or $totaCompetencias[$a][2]==2 or $totaCompetencias[$a][2]==3){
			$zeroumdoistres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==4){
			$quatro++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==5){
			$cinco++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==8){
			$oito++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==9 or $totaCompetencias[$a][2] ==10){
			$novedez++;
		}
	}
			
	//$url3 = "http://www.appweb.com.br/cms/acompanhamento.php?media=$media&zeroumdoistres=$zeroumdoistres&quatro=$quatro&cinco=$cinco&oito=$oito&novedez=$novedez&nPessoas=$nPessoas";
	//echo $url3;
	//executa_url("$url3");
	
	?>
	<p>
	<img src="graficos_grupos/acompanhamento.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    ACOMPANHAMENTO     ------>

<div class="folha">&nbsp;</div>

<!------    LIDERAN�A    ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    		<h1> 4 - Lideran�a</h4>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia o grau de identifica��o do indiv�duo com o papel de l�der.<br>
  		Sua capacidade para motivar e agregar equipes, visando a obten��o de resultados e criando um bom clima de sinergia.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	<? 
	
	$zeroquatro = $cinco = $dez = $oitonove = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] == 6 or $totaCompetencias[$a][3]== 7){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] == 0 or $totaCompetencias[$a][3]==1 or $totaCompetencias[$a][3]==2 or $totaCompetencias[$a][3]==3or $totaCompetencias[$a][3]==4){
			$zeroquatro++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==5){
			$cinco++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==8 or $totaCompetencias[$a][3] ==9 ){
			$oitonove++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==10){
			$dez++;
		}
	}
	

			
	//$url3 = "http://www.appweb.com.br/cms/lideranca.php?media=$media&zeroquatro=$zeroquatro&cinco=$cinco&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
	//echo $url3;
	//executa_url("$url3");
	
	?>
	<p>
	<img src="graficos_grupos/lideranca.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    LIDERAN�A    ------>
<div class="folha">&nbsp;</div>
<!------ COMUNICA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>5 - Comunica��o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a capacidade que o indiv�duo tem para informar com clareza e objetividade, conseguindo manter o grupo inteirado com rela��o �s mudan�as em seu local de trabalho.
</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerotres = $quatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] == 5 or $totaCompetencias[$a][4]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] == 0 or $totaCompetencias[$a][4]==1 or $totaCompetencias[$a][4]==2 or $totaCompetencias[$a][4]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] ==4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] ==7 or $totaCompetencias[$a][4] ==8 or $totaCompetencias[$a][4] ==9 or $totaCompetencias[$a][4] ==10 ){
$setedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/comunicacao.php?media=$media&zerotres=$zerotres&quatro=$quatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/comunicacao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ COMUNICA��O ------>
<div class="folha">&nbsp;</div>

<!------ DECIS�O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>6 - Decis�o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a prontid�o pessoal para o risco. Sua habilidade para decidir com maior ou menor rapidez os assuntos referentes a sua �rea de trabalho. Avalia tamb�m <br /> o grau de tomada de decis�o, rotineira ou estrat�gica.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zeroum = $doisquatro = $cinco = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 6 or $totaCompetencias[$a][5]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 0 or $totaCompetencias[$a][5]==1){
$zeroum++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 2 or $totaCompetencias[$a][5]==3 or $totaCompetencias[$a][5]==4){
$doisquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 5){
$cinco++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] ==8 or $totaCompetencias[$a][5] ==9 or $totaCompetencias[$a][5] ==10){
$oitodez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/decisao.php?media=$media&zeroum=$zeroum&doisquatro=$doisquatro&cinco=$cinco&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/decisao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ DECIS�O ------>
<div class="folha">&nbsp;</div>

<!------ DETALHISMO/DELEGA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>7 - Detalhismo/Delega��o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de necessidade que o individuo tem em trabalhar com detalhes. Sua capacidade em separar tarefas importantes, conseguindo otimizar seu tempo e delegar.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$doistres = $quatro = $cincoseis = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 0 or $totaCompetencias[$a][6]== 1){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 2 or $totaCompetencias[$a][6]==3){
$doistres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 5 or $totaCompetencias[$a][6]==6){
$cincoseis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] ==7 or $totaCompetencias[$a][6] ==8 or $totaCompetencias[$a][6] ==9 or $totaCompetencias[$a][6] ==10){
$setedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/detalhismo.php?media=$media&doistres=$doistres&quatro=$quatro&cincoseis=$cincoseis&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/detalhismo.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ DETALHISMO/DELEGA��O ------>
<div class="folha">&nbsp;</div>
<!------ TEMPO DE EXECU��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>8 - Tempo de execu��o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a capacidade do indiv�duo em trabalhar com prazos curtos e sob press�o de tempo.
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?
//zeroum doistres quatro oitonove dez
$zeroum = $doistres = $quatro = $oitonove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 5 or $totaCompetencias[$a][7]== 6 or $totaCompetencias[$a][7]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 0 or $totaCompetencias[$a][7]==1){
$zeroum++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 2 or $totaCompetencias[$a][7]==3){
$doistres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] ==8 or $totaCompetencias[$a][7] ==9){
$oitonove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] ==10){
$dez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/tempoexecucao.php?media=$media&zeroum=$zeroum&doistres=$doistres&quatro=$quatro&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/tempoexecucao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ TEMPO DE EXECU��O ------>
<div class="folha">&nbsp;</div>

<!------ INTENSIDADE OPERACIONAL ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>9 - Intensidade operacional</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o volume de trabalho que o indiv�duo est� suportando. Se necesita trabalhar em excesso, ou se est� se sentindo sub-aproveitado.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?
//zerotres seteoito nove dez
$zerotres = $seteoito = $nove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 4 or $totaCompetencias[$a][8]== 5 or $totaCompetencias[$a][8]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 0 or $totaCompetencias[$a][8]==1 or $totaCompetencias[$a][8]==2 or $totaCompetencias[$a][8]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 7 or $totaCompetencias[$a][8]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 9){
$nove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] ==10){
$dez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/intensidade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&nove=$nove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/intensidade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ INTENSIDADE OPERACIONAL ------>
<div class="folha">&nbsp;</div>

<!------ FLEXIBILIDADE - CRIATIVIDADE ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>10 - Flexibilidade - criatividade</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o volume de trabalho que o indiv�duo est� suportando. Se necesita trabalhar em excesso, ou se est� se sentindo sub-aproveitado.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?
//tres quatroseis setedez
$tres = $quatroseis = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 0 or $totaCompetencias[$a][9]== 1 or $totaCompetencias[$a][9]== 2){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 4 or $totaCompetencias[$a][9]==5 or $totaCompetencias[$a][9]==6){
$quatroseis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 7 or $totaCompetencias[$a][9]==8 or $totaCompetencias[$a][9]==9 or $totaCompetencias[$a][9]==10){
$setedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/criatividade.php?media=$media&tres=$tres&quatroseis=$quatroseis&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/criatividade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ FLEXIBILIDADE - CRIATIVIDADE ------>
<div class="folha">&nbsp;</div>

<!------ PERCEP��O / PRIORIZA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>11 - Percep��o / prioriza��o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de aten��o concentrada em um assunto ou tarefa. Sugere se o comportamento � dispersivo e n�o conclusivo e se o indiv�duo consegue trabalhar <br /> com imprevistos e emerg�ncias sem se prejudicar. Avalia tamb�m sua capacidade em perceber bem o conjunto e mudar suas prioridades, conforme a demanda.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

//zerotres seis seteoito novedez
$zerotres = $seis = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 4 or $totaCompetencias[$a][10]== 5){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 0 or $totaCompetencias[$a][10]==1 or $totaCompetencias[$a][10]==2 or $totaCompetencias[$a][10]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 6){
$seis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 7 or $totaCompetencias[$a][10]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] ==9 or $totaCompetencias[$a][10]==10){
$novedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/percepsao.php?media=$media&zerotres=$zerotres&seis=$seis&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/percepsao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ PERCEP��O / PRIORIZA��O ------>
<div class="folha">&nbsp;</div>
<!------ ADAPTABILIDADE A MUNDAN�AS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>12 - Adaptabilidade a mundan�as</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a necessidade que o indiv�duo tem de mudan�as e o seu grau de adapta��o � situa��o e pessoas novas. Indica tamb�m a rapidez com que o indiv�duo se adapta � inova��es.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zeroquatro = $setenove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 0 or $totaCompetencias[$a][11]== 1 or $totaCompetencias[$a][11]== 2){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 0 or $totaCompetencias[$a][11]==1 or $totaCompetencias[$a][11]==2 or $totaCompetencias[$a][11]==3 or $totaCompetencias[$a][11]==4){
$zeroquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 7 or $totaCompetencias[$a][11]==8 or $totaCompetencias[$a][11]==9){
$setenove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 10){
$dez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/mudancas.php?media=$media&zeroquatro=$zeroquatro&setenove=$setenove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/mudancas.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ADAPTABILIDADE A MUNDAN�AS ------>
<div class="folha">&nbsp;</div>

<!------ RELA��O COM AUTORIDADE ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>13 - Rela��o com autoridade</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia se o indiv�duo est� se apresentando submisso com a figura de chefia, ou se consegue estabelecer uma rela��o de confian�a, criando um clima <br /> de parceria e abertura.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerotres = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 4 or $totaCompetencias[$a][12]== 5 or $totaCompetencias[$a][12]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 0 or $totaCompetencias[$a][12]==1 or $totaCompetencias[$a][12]==2 or $totaCompetencias[$a][12]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 7 or $totaCompetencias[$a][12]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 9 or $totaCompetencias[$a][12]==10){
$novedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/autoridade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/autoridade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ RELA��O COM AUTORIDADE ------>
<div class="folha">&nbsp;</div>

<!------ ADMINISTRA��O DE CONFLITOS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>14 - Administra��o de conflitos</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a forma como o indiv�duo reage diante de situa��es tensas.Se evita conflitos revelando-se passivo nessas ocasi�es, ou apresentam-se agressivos para <br /> resolver o problemam, mesmo que essa atitude seja incoveniente.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerodois = $tresquatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 5 or $totaCompetencias[$a][13]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 0 or $totaCompetencias[$a][13]==1 or $totaCompetencias[$a][13]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 3 or $totaCompetencias[$a][13]==4){
$tresquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 7 or $totaCompetencias[$a][13]==8 or $totaCompetencias[$a][13]==9 or $totaCompetencias[$a][13]==10){
$setedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/administracaodeconflitos.php?media=$media&zerodois=$zerodois&tresquatro=$tresquatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/administracaodeconflitos.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ADMINISTRA��O DE CONFLITOS ------>
<div class="folha">&nbsp;</div>

<!------ CONTROLE EMOCIONAL ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>15 - Controle emocional</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a habilidade do indiv�duo em lidar com suas emo��es. Se explode com facilidade, ou se reprime suas sentimentos.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerodois = $tres = $sete = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 4 or $totaCompetencias[$a][14]== 5 or $totaCompetencias[$a][14]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 0 or $totaCompetencias[$a][14]==1 or $totaCompetencias[$a][14]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 7){
$sete++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] ==8 or $totaCompetencias[$a][14]==9 or $totaCompetencias[$a][14]==10){
$oitodez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/controleemocional.php?media=$media&zerodois=$zerodois&tres=$tres&sete=$sete&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/controleemocional.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ CONTROLE EMOCIONAL ------>
<div class="folha">&nbsp;</div>

<!------ AFETIVIDADE ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>16 - Afetividade</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de envolvimento do indiv�duo com outras pessoas.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerodois = $cinco = $seisdez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 3 or $totaCompetencias[$a][15]== 4){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 0 or $totaCompetencias[$a][15]==1 or $totaCompetencias[$a][15]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 5){
$cinco++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 6 or $totaCompetencias[$a][15]==7 or $totaCompetencias[$a][15]==8 or $totaCompetencias[$a][15]==9 or $totaCompetencias[$a][15]==10){
$seisdez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/afetividade.php?media=$media&zerodois=$zerodois&cinco=$cinco&seisdez=$seisdez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/afetividade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ AFETIVIDADE ------>
<div class="folha">&nbsp;</div>
<!------ SOCIABILIDADE ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>17 - Sociabilidade</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de necessidade do indiv�duo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamento de colabora��o e individualismo <br /> e o n�vel de concess�o dispendida a outra pessoa.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zerotres = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 4 or $totaCompetencias[$a][16]== 5 or $totaCompetencias[$a][16]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 0 or $totaCompetencias[$a][16]==1 or $totaCompetencias[$a][16]==2 or $totaCompetencias[$a][16]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 7 or $totaCompetencias[$a][16]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 9 or $totaCompetencias[$a][16]==10){
$novedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/sociabilidade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/sociabilidade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ SOCIABILIDADE ------>
<div class="folha">&nbsp;</div>
<!------ AUTO-IMAGEM ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>18 - Auto-imagem</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a forma como o indiv�duo � percebido pelo grupo e o seu grau de auto-estima.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zero = $umdois = $tres = $cincodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 4){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 0){
$zero++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 1 or $totaCompetencias[$a][17]==2){
$umdois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] ==5 or $totaCompetencias[$a][17]==6 or $totaCompetencias[$a][17]==7 or $totaCompetencias[$a][17]==8 or $totaCompetencias[$a][17]==9 or $totaCompetencias[$a][17]==10){
$cincodez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/autoimagem.php?media=$media&zero=$zero&umdois=$umdois&tres=$tres&cincodez=$cincodez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/autoimagem.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ AUTO-IMAGEM ------>
<div class="folha">&nbsp;</div>
<!------ ENERGIA VITAL ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>19 - Energia vital</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o n�vel de vitalidade do indiv�duo, revelando-se "estresquatrosado" por excesso de trabalho, ou por estar enfrentando algum problema emocional. <br /> Tamb�m avalia o n�vel do clima organizacional, caso haja muitas pessoas com baixo t�nus vital.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$zero = $umdois = $tresquatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 5 or $totaCompetencias[$a][18]==6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 0){
$zero++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 1 or $totaCompetencias[$a][18]==2){
$umdois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 3 or $totaCompetencias[$a][18]==4){
$tresquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18]==7 or $totaCompetencias[$a][18]==8 or $totaCompetencias[$a][18]==9 or $totaCompetencias[$a][18]==10){
$setedez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/energiavital.php?media=$media&zero=$zero&umdois=$umdois&tresquatro=$tresquatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
//executa_url("$url3");

?>
<p>
<img src="graficos_grupos/energiavital.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ENERGIA VITAL ------>
<div class="folha">&nbsp;</div>
<!------ REALIZA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
<h1>20 - Realiza��o</h4>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a necessidade do indiv�duo em atingir suas metas de vida. Est� relacionado �s suas realiza��es do momento.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<?

$umtres = $quatro = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 5 or $totaCompetencias[$a][19]== 6 or $totaCompetencias[$a][19]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 0 or$totaCompetencias[$a][19] == 1 or $totaCompetencias[$a][19]==2 or $totaCompetencias[$a][19]==3){
$umtres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 8 or $totaCompetencias[$a][19]==9 or $totaCompetencias[$a][19]==10){
$oitodez++;
}
}

//$url3 = "http://www.appweb.com.br/cms/realizacao.php?media=$media&umtres=$umtres&quatro=$quatro&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
////executa_url("$url3");

?>
<p>
<img src="graficos_grupos/realizacao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ REALIZA��O ------>

</body>
</html>
		