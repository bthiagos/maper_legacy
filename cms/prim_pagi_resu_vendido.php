<? include("library.php");?>
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
<p>
<?php
$letras = array();

$codigo_id = $_REQUEST["id"]; 
$orga = $_REQUEST["orga"]; 
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

$t = "aplicacoes".$tabela_commit;

//CONECTA AO MYSQL                     
include("conn.php");
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

$pGabarito = $linha["respostas"];
//echo $pGabarito;
if (!$pGabarito) {

$pGabarito = $_REQUEST["gabarito"]; 

}



$pNome = $linha["nome"]; 
$pCpf = $linha["cpf"]; 
$cpf = formatarCPF_CNPJ($pCpf);
$pNasc = $linha["nasc"];  
$pPerfil = "Profissional"; 
$pCargo= $linha["cargo"];  
$pdata_aplic= date('d/m/Y',strtotime($linha["data_aplic"]));  
$pSenha= "Spider29";  
//$pGabarito = "ababbbbbbbaabbababaaaaaababbbbaabaaaaaaabbbaaabbabbbbbaaaaaabbbbbaaaaabbbbabababbbabbaaaaaaabababbbb";

// teste Mariana"abababbaaaabaabaaaabbaababbbaaaabbbbbbbabbbbabaababbaabababaaaabbabbbaaaaababababaaaababaaabaaababaa";
//teste Leandro $pGabarito = "abaaaaaabaababbbaaababaababbaaaababaaababbaaababbabababaaaabbbaababaaabbbaaabbabaaaabbbaaabbabbbbbaa";

$i = $j = $total = 0; $login =0;
$Opcao = "";
$id_competencia = "";
$sql = "";
$row = "";
$competencias [20];
$nome_competencias[20];


	$i = 0;
	while ($i<20){
		$competencias[$i]=0;
		$i++;
	}
	
switch ($pSenha) {	
	case "Spider29": $login=1; break; 
	case "Logus05": $login=1; break;
	case "Moto08": $login=1; break;
	case "Zero05": $login=1; break;
	default: $login=0; break;
}

if ($login==1){
if (strlen($pGabarito)==100){

	   		$sql = " 
       		SELECT c.descricao 
       		FROM  competencias c
	   		ORDER BY c.ordem";   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    
			
			//echo $row;
			/*
			for ($i=0; $i<$row; $i++){
   				$nome_competencias[$i] = htmlentities (mysql_result($sql, $i, "descricao"));
   				echo $nome_competencias[$i] . " - ".$i."<br/>"; 
			}
			 *
			 */
			$i=0; 
			while ($linha = mysql_fetch_assoc($sql)) {
				//echo $linha["descricao"] . " - ".$i."<br/>";
				$nome_competencias[$i] = $linha["descricao"];
				$i++;
			}



	$i = 0;
	while ($i<100){
		
		$Opcao = $pGabarito[$i];
		
		if (strcmp($Opcao, "a") || strcmp($Opcao, "b")){
			//QUERY  
	   		$sql = " 
       		SELECT c.ordem 
       		FROM  questoes q, competencias c
	   		WHERE q.competencia_id=c.competencias_id and q.ordem = ". ($i+1) . " and q.sequencia like \"" . $Opcao . "\"";   



			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca das questões");    
			
   			$id_competencia  = mysql_result($sql, 0, "ordem");
			$competencias[$id_competencia-1]++;

		} //fim do if
		$i++;
	} //fim do while

	
	
?>
</p>


<?if($_REQUEST["commit"] == 1){?>
<!-- 
<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?> <br /><strong>Respondido em:</strong> <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?> <br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="1" cellpadding="2"  align="center">
  <tr>
  	<td>
<b>APP� - ORIENTA��ES PARA INTERPRETA��O DE SEU PERFIL</b><br/><br/>

Os resultados preliminares da pesquisa brasileira com o APP� indicam que, para a amostra pesquisada, nossos profissionais revelam fatores similares ao perfil<br/> demandado no mercado global, mas tamb�m apresentam especificidades t�picas de um povo latino, colonizados por portugueses e fortemente influenciados<br/> pela forma��o religiosa cat�lica.<br/><br/>

Neste sentido, algumas observa��es s�o pertinentes com rela��o aos comportamentos apresentados pelos profissionais brasileiros:<br/><br/>

-	A auto-estima do brasileiro � muito rebaixada e, portanto, apesar de ser um profissional que possui autoconfian�a, 83,4% apresentam baixa auto-imagem e<br/> n�o sabem fazer marketing pessoal;<br/><br/>

-	apesar de o cidad�o brasileiro ser considerado altamente criativo pela maioria dos escritores, 92,1% dos profissionais segue normas em excesso, bloqueando<br/> sua criatividade. Sem d�vida, somos considerados muito criativos e devemos apresentar um alto grau de inventividade, mas parece que deixamos para aplicar<br/> todo este potencial fora dos limites das organiza��es;<br/><br/>

-	87,2% dos profissionais apresentam facilidade para aceitar mudan�as e inova��es, todavia, 89,1% t�m dificuldades para lidar com imprevistos e emerg�ncias.<br/> Parece que aceitamos bem mudan�as, mas n�o gostamos de improvisa��o, principalmente os �perfeccionistas�; <br/><br/>

-	o resultado assinalado (tra�o sob o n�mero) � o ideal e a sua nota corresponde ao seu desempenho atual.<br/><br/>

Al�m disso, � importante ressaltar que:<br/><br/>

-	O ser humano � �nico, genu�no e exclusivo;<br/><br/>

-	Cada momento de sua vida o influenciar� no desempenho de suas habilidades e compet�ncias, todavia a ess�ncia de sua personalidade � preservada.<br/><br/>

-	O comportamento humano n�o pode ser mensurado de forma cartesiana, e apesar de revelarmos indicadores pelo Invent�rio APP� � necess�rio<br/> compreendermos que as ambig�idades s�o naturais do ser humano.<br/><br/>


E, finalmente compreendemos que somos todos indiv�duos repletos de potencialidades e fragilidades que alimentam o nosso �sabor� pela vida. Enfatize suas<br/> potencialidades e estabele�a suas metas pessoais e profissionais com foco e determina��o, por meio do autoconhecimento.<br/><br/>

E seja feliz, pois voc� MERECE!<br/><br/>

<b>Maria L�cia Rodrigues Corr�a<br/>
Respons�vel - Equipe APP�<br/>
CRP 1560</b><br/>

	</td>
 </tr>
</table>

<hr style="height: 1px; width: 80%; color: #666666; margin-top:50%;">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<div class="folha">&nbsp;</div>


<table width="90%" border="0"  cellspacing="0" style="margin-top: -90px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -40px;"  align="center">
  <tr>
  	<td>
<b>APP� - DEFINI��ES DAS HABILIDADES E COMPET�NCIAS</b><br/><br/>

1.	Capacidade de planejamento<br/>
Avalia a capacidade de planejamento do profissional que � definida como a a��o para se criar recursos para atingir os objetivos.<br/><br/>


2.	Capacidade de organiza��o<br/>
Avalia a capacidade que o indiv�duo apresenta em rela��o a aspectos organizativos e � administra��o do tempo. <br/><br/>


3.	Capacidade de Acompanhamento (Lideran�a COACH)<br/>
Avalia a capacidade que o indiv�duo apresenta para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, informa��es, feedbacks e orienta��es.<br/><br/>


4.	Estilo de lideran�a<br/>
Avalia o grau de identifica��o do indiv�duo com o papel de l�der e sua capacidade para motivar e agregar equipes, visando � obten��o de resultados e cria��o de um bom clima de sinergia.<br/><br/>


5.	Estilo de comunica��o<br/>
Avalia a capacidade que o indiv�duo tem para informar com clareza e objetividade.<br/><br/>


6.	Tomada de decis�o<br/>
Avalia a prontid�o pessoal para o risco. Avalia tamb�m sua habilidade para decidir com maior ou menor rapidez, se h� autonomia para decidir ou se h� omiss�o.<br/><br/>


7.	Capacidade de delega��o<br/>
Avalia o grau de necessidade do indiv�duo em trabalhar com detalhes e sua capacidade de delega��o.<br/><br/>


8.	Administra��o do tempo<br/>
Avalia a capacidade do indiv�duo em trabalhar com prazos curtos e sob press�o de tempo.<br/><br/>


9.	Volume de trabalho<br/>
Avalia o volume de trabalho que o profissional suporta, se ele necessita trabalhar em excesso, ou se est� se sentindo subaproveitado.<br/><br/>


10.	Potencial criativo e flexibilidade<br/>
Avalia a necessidade que o indiv�duo tem em seguir normas, regras, procedimentos, metodologias, etc. ou sua necessidade em trabalhar com liberdade de express�o para criar.<br/><br/>

11.	Capacidade de priorizar e trabalhar com imprevistos<br/>
Avalia o grau de aten��o concentrada e indica se o comportamento � dispersivo ou se a pessoa consegue estabelecer suas prioridades e trabalhar com imprevistos e emerg�ncias. Mensura tamb�m sua capacidade em perceber o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	Gest�o de mudan�as<br/>
Avalia a necessidade que o profissional apresenta em aceitar e adaptar-se �s mudan�as e inova��es. <br/><br/>


13.	Relacionamento com superiores<br/>
Avalia se o profissional � submisso ou evita seus superiores, ou se consegue estabelecer uma rela��o de confian�a, criando um clima de parceria e abertura.<br/><br/>

14.	Gest�o de conflitos<br/>
Avalia a forma como o profissional reage diante de situa��es tensas. Se evita conflitos revelando-se passivo, ou apresenta-se agressivo mediante estas situa��es.<br/><br/>


15.	Controle das emo��es<br/>
Avalia a habilidade do indiv�duo em lidar com suas emo��es. Se explode com facilidade, ou se reprime seus sentimentos. <br/><br/>

16.	Relacionamento afetivo<br/>
Avalia o grau de envolvimento do profissional com outras pessoas. Se consegue dividir seus problemas, se � muito reservado, ou se faz muita concess�o para as pessoas de sua confian�a.
<br/><br/>



	</td>
 </tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:110px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>

<table width="90%" border="0"  cellspacing="0" style="margin-top:-400px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

						
<b>INSTRU��ES:</b><br/><br/>

A seguir � apresentado o seu resultado APP com base em 20 habilidades/compet�ncias pessoais e profissionais. Ele est� organizado com as colunas CRIT�RIO, NOTA e AVALIA��O e enumerado de 1 a 20. <br/> <br/> 

Cada CRIT�RIO equivale a uma habilidade/compet�ncia e lhe � atribu�da uma NOTA de 0 (zero) � 10 (dez)  e seu resultado corresponde a um destes valores.<br/> <br/>  

A coluna AVALIA��O possui um texto personalizado de acordo com a sua NOTA no respectivo CRIT�RIO.<br/> <br/> 

Para facilitar posteriormente sua interpreta��o s�o apresentados 2 gr�ficos para melhor entendimento do seu resultado. Sempre avaliamos como m�dia ideal - a NOTA 7.<br/> <br/> 

Est� dispon�vel, tamb�m na �ltima p�gina, um quadro que ir� lhe fornecer uma vis�o clara de que compet�ncias e habilidades voc� deve priorizar  para o seu desenvolvimento  pessoal e profissional.<br/> <br/> 

Lembre-se que as habilidades ou compet�ncias devem ser priorizadas conforme o cargo e tipo de organiza��o, para melhor atender o perfil do profissional desejado, pois cada situa��o deve ser customizada �s necessidades espec�ficas.
			</td>
		
		</tr>
		<tr>&nbsp;</tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:70%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>
-->

<?}?>



<? if($_REQUEST["orga"] != 999999) { ?>

<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="1" cellpadding="2"  align="center">
  <tr>
  	<td>
<b>APP� - ORIENTA��ES PARA INTERPRETA��O DE SEU PERFIL</b><br/><br/>

Os resultados preliminares da pesquisa brasileira com o APP� indicam que, para a amostra pesquisada, nossos profissionais revelam fatores similares ao perfil<br/> demandado no mercado global, mas tamb�m apresentam especificidades t�picas de um povo latino, colonizados por portugueses e fortemente influenciados<br/> pela forma��o religiosa cat�lica.<br/><br/>

Neste sentido, algumas observa��es s�o pertinentes com rela��o aos comportamentos apresentados pelos profissionais brasileiros:<br/><br/>

-	A autoestima do brasileiro � muito rebaixada e, portanto, apesar de ser um profissional que possui autoconfian�a, 53,8% apresentam baixa autoimagem e <br/> n�o sabem fazer marketing pessoal;<br/><br/> 

-	apesar de o cidad�o brasileiro ser considerado altamente criativo pela maioria dos escritores, 93,1% dos profissionais segue normas em excesso, bloqueando<br/> sua criatividade. Sem d�vida, somos considerados muito criativos e devemos apresentar um alto grau de inventividade, mas parece que deixamos para aplicar<br/> todo este potencial fora dos limites das organiza��es;<br/><br/>

-	78,4% dos profissionais apresentam facilidade para aceitar mudan�as e inova��es, todavia, 52,8% t�m dificuldades para lidar com imprevistos e emerg�ncias.<br/> Parece que aceitamos bem mudan�as, mas n�o gostamos de improvisa��o, principalmente os �perfeccionistas�; <br/><br/>

-	O resultado assinalado (tra�o sob o n�mero) � o ideal e a sua nota  � o n�mero que est� ao lado e corresponde ao seu desempenho atual.<br/><br/>

Al�m disso, � importante ressaltar que:<br/><br/>

-	O ser humano � �nico, genu�no e exclusivo;<br/><br/>

-	Cada momento de sua vida o influenciar� no desempenho de suas habilidades e compet�ncias, todavia a ess�ncia de sua personalidade � preservada.<br/><br/>

-	O comportamento humano n�o pode ser mensurado de forma cartesiana, e apesar de revelarmos indicadores pelo Invent�rio APP� � necess�rio<br/> compreendermos que as ambig�idades s�o naturais do ser humano.<br/><br/>


E, finalmente � preciso entender que somos todos indiv�duos repletos de potencialidades e fragilidades. Enfatize<br/> suas potencialidades e estabele�a suas metas pessoais e profissionais com foco e determina��o, por meio do autoconhecimento.<br/><br/>

E seja feliz, pois voc� MERECE!<br/><br/>

<b>Maria L�cia Rodrigues Corr�a<br/>
Respons�vel - Equipe APP�<br/>
CRP 1560</b><br/>

	</td>
 </tr>
</table>

<hr style="height: 1px; width: 80%; color: #666666; margin-top:50%;">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<div class="folha">&nbsp;</div>


<table width="90%" border="0"  cellspacing="0" style="margin-top: -90px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -40px;"  align="center">
  <tr>
  	<td>
<b>APP� - DEFINI��ES DAS HABILIDADES E COMPET�NCIAS</b><br/><br/>

1.	CAPACIDADE DE PLANEJAMENTO<br/>
Avalia a capacidade de planejamento do profissional que � definida como a a��o para se criar recursos para atingir os objetivos.<br/><br/>


2.	CAPACIDADE DE ORGANIZA��O<br/>
Avalia a capacidade que o indiv�duo apresenta em rela��o a aspectos organizativos e � administra��o do tempo. <br/><br/>


3.	CAPACIDADE DE ACOMPANHAMENTO (LIDERAN�A COACH)<br/>
Avalia a capacidade que o indiv�duo apresenta para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, <br/>informa��es, feedbacks e orienta��es.<br/><br/>


4.	ESTILO DE LIDERAN�A<br/>
Avalia o grau de identifica��o do indiv�duo com o papel de l�der e sua capacidade para motivar e agregar equipes, visando � obten��o de resultados e <br/>cria��o de um bom clima de sinergia.<br/><br/>


5.	ESTILO DE COMUNICA��O<br/>
Avalia a capacidade que o indiv�duo tem para informar com clareza e objetividade.<br/><br/>


6.	TOMADA DE DECIS�O<br/>
Avalia a prontid�o pessoal para o risco. Avalia tamb�m sua habilidade para decidir com maior ou menor rapidez, se h� autonomia para decidir ou <br/>se h� omiss�o.<br/><br/>


7.	CAPACIDADE DE DELEGA��O<br/>
Avalia o grau de necessidade do indiv�duo em trabalhar com detalhes e sua capacidade de delega��o.<br/><br/>


8.	ADMINISTRA��O DO TEMPO<br/>
Avalia a capacidade do indiv�duo em trabalhar com prazos curtos e sob press�o de tempo.<br/><br/>


9.	VOLUME DE TRABALHO<br/>
Avalia o volume de trabalho que o profissional suporta, se ele necessita trabalhar em excesso, ou se est� se sentindo subaproveitado.<br/><br/>


10.	POTENCIAL CRIATIVO E FLEXIBILIDADE<br/>
Avalia a necessidade que o indiv�duo tem em seguir normas, regras, procedimentos, metodologias, etc. ou sua necessidade em trabalhar com <br/>liberdade de express�o para criar.<br/><br/>

11.	CAPACIDADE DE PRIORIZAR E TRABALHAR COM IMPREVISTOS<br/>
Avalia o grau de aten��o concentrada e indica se o comportamento � dispersivo ou se a pessoa consegue estabelecer suas prioridades e trabalhar <br/>com imprevistos e emerg�ncias. Mensura tamb�m sua capacidade em perceber o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	GEST�O DE MUDAN�AS<br/>
Avalia a necessidade que o profissional apresenta em aceitar e adaptar-se �s mudan�as e inova��es. <br/><br/>


13.	RELACIONAMENTO COM SUPERIORES<br/>
Avalia se o profissional � submisso ou evita seus superiores, ou se consegue estabelecer uma rela��o de confian�a, criando um clima de parceria e <br/>abertura.<br/><br/>

14.	GEST�O DE CONFLITOS<br/>
Avalia a forma como o profissional reage diante de situa��es tensas. Se evita conflitos revelando-se passivo, ou apresenta-se agressivo mediante <br/>estas situa��es.<br/><br/>


15.	CONTROLE DAS EMO��ES<br/>
Avalia a habilidade do indiv�duo em lidar com suas emo��es. Se explode com facilidade, ou se reprime seus sentimentos.<br/><br/>

16.	AFETIVIDADE<br/>
Avalia o grau de envolvimento do profissional com outras pessoas. Se consegue dividir seus problemas, se � muito reservado, ou se faz muita <br/>concess�o para as pessoas de sua confian�a.<br/><br/>
<br/><br/>


	</td>
 </tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:110px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>

<table width="90%" border="0"  cellspacing="0" style="margin-top:-400px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -350px;"  align="center">
  <tr>
  	<td>
<b>APP� - DEFINI��ES DAS HABILIDADES E COMPET�NCIAS</b><br/><br/>


17.	RELACIONAMENTO EM GRUPOS<br/>
Avalia a necessidade do indiv�duo em se integrar, pertencer, dar e receber apoio de grupos. Revela comportamentos de colabora��o e o n�vel de concess�o feita a outras pessoas para agradar o grupo.<br/><br/>

18.	IMAGEM PESSOAL<br/>
Avalia a forma como o indiv�duo � percebido e o seu grau de autoestima. Se � autoconfiante, ou tem dificuldades  para fazer seu marketing pessoal, ou se � considerado �exibicionista�.<br/><br/>


19.	T�NUS VITAL<br/>
Avalia o n�vel de vitalidade do indiv�duo, se na m�dia, euf�rico,  ou se est� �estressado� por excesso de trabalho ou problemas pessoais.  O t�nus vital pode sofrer impactos em virtude do grau de motiva��o do profissional.<br/><br/>


20.	NECESSIDADE DE REALIZA��O<br/>
Avalia a necessidade do indiv�duo em atingir suas metas de vida pessoais e profissionais e seu grau de motiva��o em rela��o aos seus  desafios.<br/><br/> <br/> 


	</td>
 </tr>
 
 	<tr>
			<td colspan="4">
			
			
<b>INSTRU��ES:</b><br/><br/>

A seguir � apresentado o seu resultado APP com base em 20 habilidades/compet�ncias pessoais e profissionais. Ele est� organizado com as colunas CRIT�RIO, NOTA e AVALIA��O e enumerado de 1 a 20. <br/> <br/> 

Cada CRIT�RIO equivale a uma habilidade/compet�ncia e lhe � atribu�da uma NOTA de 0 (zero) � 10 (dez)  e seu resultado corresponde a um destes valores.<br/> <br/>  

A coluna AVALIA��O possui um texto personalizado de acordo com a sua NOTA no respectivo CRIT�RIO.<br/> <br/> 

Para facilitar posteriormente sua interpreta��o s�o apresentados 2 gr�ficos para melhor entendimento do seu resultado. Sempre avaliamos como m�dia ideal - a NOTA 7.<br/> <br/> 

Est� dispon�vel, tamb�m na �ltima p�gina, um quadro que ir� lhe fornecer uma vis�o clara de que compet�ncias e habilidades voc� deve priorizar  para o seu desenvolvimento  pessoal e profissional.<br/> <br/> 

Lembre-se que as habilidades ou compet�ncias devem ser priorizadas conforme o cargo e tipo de organiza��o, para melhor atender o perfil do profissional desejado, pois cada situa��o deve ser customizada �s necessidades espec�ficas.
			</td>
		
		</tr>
		<tr>&nbsp;</tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:70%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>


<?}?>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><span style="font-size:8px;"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?></span><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"><span style="font-size:8px;"><strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="90%" border="0" cellspacing="0" cellpadding="1"  align="center">
	
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="9%" nowrap><span class="style17">Crit�rio</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avalia��o</span></td>
  </tr>    

  <?php
	$i = 0;
	$linha_arquivo = 1;
//	echo "<p><b>Competências:</b></p>";
	while ($i<20){ 
		?>
	
		<tr><td width="2%" valign="top">		
		<? echo ($i+1); ?>
		</td><td width="9%" style="font-size:8px; " valign="top">
		<? echo $nome_competencias[$i] . "<br>"; 
		 ?>
		</td><td  width="5%" valign="top" align="center">
		<? echo $nota110 = base10(($i+1),$competencias[$i]); ?>
		</td><td align="left" valign="top" style="font-size:8px; font-align:center; border:0px solid #000000"><div style="width: 100%;text-align: justify;">
		<? $texto = feedback(($i+1),$competencias[$i]); ?>
		<p style="padding: 0 0 0 0; margin: 0 0 10px 0; text-align: justify;" >	
			<? 
				$num_linhas = 0;
				$caracteres = 0; 
			   
			$novotexto = wordwrap($texto, 100, "<br />");
			echo $novotexto;
			?>
		</p>
		</div></td></tr>
		<?
		if ($linha_arquivo == 10 && $i < 19) {
		?>
		</table>
		
		<hr style="height: 1px; width: 80%; color: #666666; margin-top:2px">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<div class="folha">&nbsp;</div>
		
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:10px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?></td>
          <td width="52%">  <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="90%" border="0" cellspacing="0" cellpadding="2"  align="center">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="9%" nowrap><span class="style17">Crit�rio</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avalia��o</span></td>
  </tr>    

<?
			$linha_arquivo =-2;
		}
		
		
		$total = $total + $competencias[$i];
		$i++;
		$linha_arquivo++;
	}
//	echo "Total = " . $total;
//	echo "<p><b>Concluído</b></p>";
}//fim do if
}//fim do if

function base10 ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao, f.base10
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   


			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    
			
		
			return $a = mysql_result($sql, 0, "base10");
		

}


function feedback ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao 
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   
			
			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    
			
			$pos = (mysql_result($sql, 0, "descricao"));
			return $pos;

}


mysql_close($conn);

?>






</table>

<? if($orga == 999999){ ?>
<? 
include("conn.php");
$notamedia2 = 0;
			$n = 0;
			while ($n<20){
				$nota110a = base10(($n+1),$competencias[$n]);
				$notamedia2 += $nota110a;
					$n++;
			}
	?>		
			<p style="margin-top: 5px; margin-left: 20px;"><span style="text-transform:uppercase; font-size:12px;" >Nota Geral - m�dia das 20 compet�ncias :<?	echo ($notamedia2/20); ?></span><p>
		
<?}?>
		<div style="width:80%; height: 10px"></div>
		<hr style="height: 1px; width: 80%; color: #666666; margin-top: 25px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
<div class="folha">&nbsp;</div>







<? 	 $codigo_id2 = $codigo_id."grafico2.png"; 
$codigo_id = $codigo_id."grafico.png"; 

?>


		<? if($orga != 999999){ ?>
<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:  </strong> <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<br/>
<p style="margin-top: 0px;"><center><img src="graficos_vendidos/<?=$codigo_id2?>"/></center></p>
<br/>
<p style="margin-top: 10px;"><center><img src="graficos_vendidos/<?=$codigo_id?>"/></center></p>


		<hr style="height: 1px; width: 80%; color: #666666; margin-top:20px">
		<div style="margin-top: 20px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>

		
<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong>  <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<p>&nbsp;</p>
<p style="margin-left: 30px;">
A tabela a seguir possui 3 colunas sendo Sustenta��o, Aceit�vel e Cr�tico.<br />
Por "Sustenta��o" entenda pelos "pontos fortes" do candidato que remetem aos fatores de excel�ncia.<br />
Na segunda coluna, compreenda que s�o os fatores aceit�veis, ou seja, est�o adequados mas podem evoluir mais. <br />
Por �ltimo, os fatores cr�ticos sugerem as compet�ncias que podem prioritariamente ser trabalhadas.<br /><br /> 

� importante lembrar que essa � uma classifica��o generalizada e deve ser adequada �s compet�ncias organizacionais, portanto, ao perfil de cada cargo.</p>


<p style="margin-top: 10px; margin-left: 25px;"><? include("tabela2_vendido.php"); ?></p>
<? 
$notamedia = 0;
			$i = 0;
			while ($i<20){
				$nota110 = base10(($i+1),$competencias[$i]);
				$notamedia += $nota110;
					$i++;
			}
	?>		
	<p style="margin-top: 5px; margin-left: 45px;"><span style="text-transform:uppercase; font-size:15px;" >Nota Geral - m�dia das 20 compet�ncias :<?	echo ($notamedia/20); ?></span><p>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:30%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		<?}?>
		
		
<script language='JavaScript'>history.go(1);</script>
</body>
</html>

