<? include("library.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
<style type="text/css">
.style17 {font-family: Arial; font-size: 12px; font-weight: bold; }
.style18 {font-family: Helvetica; font-size: 12px; }
body,td,th {
	font-family: Arial, Helvetica, serif;
	font-size: 12px;
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
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
			for ($i=0; $i<$row; $i++){
   				$nome_competencias[$i] = htmlentities (mysql_result($sql, $i, "descricao"));
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
			$row = mysql_num_rows($sql) or die("erro na busca das questÃµes");    
			
   			$id_competencia  = mysql_result($sql, 0, "ordem");
			$competencias[$id_competencia-1]++;

		} //fim do if
		$i++;
	} //fim do while
	
?>
</p>


<?if($_REQUEST["commit"] == 1){?>
<!-- 
<table width="100%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2"  align="center">
  <tr>
  	<td>
<b>APP® - ORIENTAÇÕES PARA INTERPRETAÇÃO DE SEU PERFIL</b><br/><br/>

Os resultados preliminares da pesquisa brasileira com o APP® indicam que, para a amostra pesquisada, nossos profissionais revelam fatores similares ao perfil<br/> demandado no mercado global, mas também apresentam especificidades típicas de um povo latino, colonizados por portugueses e fortemente influenciados<br/> pela formação religiosa católica.<br/><br/>

Neste sentido, algumas observações são pertinentes com relação aos comportamentos apresentados pelos profissionais brasileiros:<br/><br/>

-	A auto-estima do brasileiro é muito rebaixada e, portanto, apesar de ser um profissional que possui autoconfiança, 83,4% apresentam baixa auto-imagem e<br/> não sabem fazer marketing pessoal;<br/><br/>

-	apesar de o cidadão brasileiro ser considerado altamente criativo pela maioria dos escritores, 92,1% dos profissionais segue normas em excesso, bloqueando<br/> sua criatividade. Sem dúvida, somos considerados muito criativos e devemos apresentar um alto grau de inventividade, mas parece que deixamos para aplicar<br/> todo este potencial fora dos limites das organizações;<br/><br/>

-	87,2% dos profissionais apresentam facilidade para aceitar mudanças e inovações, todavia, 89,1% têm dificuldades para lidar com imprevistos e emergências.<br/> Parece que aceitamos bem mudanças, mas não gostamos de improvisação, principalmente os “perfeccionistas”; <br/><br/>

-	o resultado assinalado (traço sob o número) é o ideal e a sua nota corresponde ao seu desempenho atual.<br/><br/>

Além disso, é importante ressaltar que:<br/><br/>

-	O ser humano é único, genuíno e exclusivo;<br/><br/>

-	Cada momento de sua vida o influenciará no desempenho de suas habilidades e competências, todavia a essência de sua personalidade é preservada.<br/><br/>

-	O comportamento humano não pode ser mensurado de forma cartesiana, e apesar de revelarmos indicadores pelo Inventário APP® é necessário<br/> compreendermos que as ambigüidades são naturais do ser humano.<br/><br/>


E, finalmente compreendemos que somos todos indivíduos repletos de potencialidades e fragilidades que alimentam o nosso “sabor” pela vida. Enfatize suas<br/> potencialidades e estabeleça suas metas pessoais e profissionais com foco e determinação, por meio do autoconhecimento.<br/><br/>

E seja feliz, pois você MERECE!<br/><br/>

<b>Maria Lúcia Rodrigues Corrêa<br/>
Responsável - Equipe APP®<br/>
CRP 1560</b><br/>

	</td>
 </tr>
</table>

<hr style="height: 1px; width: 80%; color: #666666; margin-top:50%;">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<div class="folha">&nbsp;</div>


<table width="100%" border="0"  cellspacing="0" style="margin-top: -90px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -40px;"  align="center">
  <tr>
  	<td>
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>

1.	PLANEJAMENTO<br/>
Avalia o grau de identificação do indivíduo com a atividade de planejar. Entende-se a capacidade de planejamento como ação de criar recursos para se atingir<br/> os objetivos, definindo as linhas de ação, prazos e meios.<br/><br/>


2.	ORGANIZAÇÃO<br/>
Avalia a capacidade que o indivíduo possui com aspectos organizativos e com a administração do tempo.<br/><br/>


3.	ACOMPANHAMENTO<br/>
Avalia a capacidade do indivíduo para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, fornecimento de informações,<br/> dados e orientações.<br/><br/>


4.	LIDERANÇA<br/>
Avalia o grau de identificação do indivíduo com o papel de líder. Sua capacidade para motivar e agregar equipes, visando a obtenção de resultados e criando<br/> um bom clima de sinergia.<br/><br/>


5.	COMUNICAÇÃO<br/>
Avalia a capacidade que o indivíduo tem para informar com clareza e objetividade, conseguindo manter o grupo inteirado com relação às mudanças relevantes<br/> em  sua área de trabalho.<br/><br/>


6.	DECISÃO<br/>
Avalia a prontidão pessoal para o risco. Sua  habilidade para decidir com maior ou menor rapidez os assuntos referentes à sua área de trabalho. Avalia<br/> também o grau de tomada de decisão, rotineira ou estratégica.<br/><br/>


7.	DETALHISMO/DELEGAÇÃO<br/>
Avalia o grau de necessidade que o indivíduo tem em trabalhar com detalhes. Sua capacidade em separar as tarefas importantes das não importantes,<br/> conseguindo otimizar o seu tempo e delegar.<br/><br/>


8.	TEMPO DE EXECUÇÃO<br/>
Avalia a capacidade do indivíduo em  trabalhar com prazos curtos e sob pressão de tempo.<br/><br/>


9.	INTENSIDADE OPERACIONAL<br/>
Avalia o volume de trabalho que o indivíduo está suportando. Se a pessoa necessita trabalhar em excesso, ou se está se sentindo subaproveitado.<br/><br/>


10.	FLEXIBILIDADE - CRIATIVIDADE<br/>
Avalia o grau de necessidade que o indivíduo tem em seguir normas, regras, valores, metodologias, etc., para a execução de suas tarefas. Não sugere<br/> a ausência de normas, mas sim a utilização de padrões, permitindo a criatividade.<br/><br/>

11.	PERCEPÇÃO / PRIORIZAÇÃO<br/>
Avalia o grau de atenção concentrada em um assunto ou tarefa. Sugere se o comportamento é dispersivo e não conclusivo e se consegue trabalhar com<br/> imprevistos e emergências, sem se prejudicar. Avalia também sua capacidade de perceber bem o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	ADAPTABILIDADE A MUDANÇAS<br/>
Avalia a necessidade que o indivíduo tem de mudanças e o seu grau de adaptação às situações e pessoas novas. Indica também a rapidez com que o<br/> indivíduo se adapta às inovações.<br/><br/>


13.	RELAÇÃO COM AUTORIDADE<br/>
Avalia se o indivíduo está se apresentando submisso com a figura de chefia, ou se consegue estabelecer relação de confiança, criando um clima de parceria<br/> e abertura, favorecendo os resultados.<br/><br/>

14.	ADMINISTRAÇÃO DE CONFLITOS<br/>
Avalia a forma como o indivíduo reage diante de situações tensas. Se evita conflitos revelando-se passivo nessas ocasiões, ou apresenta-se agressivo para<br/> resolver o problema, mesmo que essa atitude seja inconveniente.<br/><br/>


15.	CONTROLE EMOCIONAL<br/>
Avalia a habilidade do indivíduo em lidar com suas emoções. Se a pessoa explode com facilidade, ou se reprime seus sentimentos. <br/><br/>

16.	AFETIVIDADE<br/>
Avalia o grau de envolvimento do indivíduo com outras pessoas.<br/><br/>
<br/><br/>



	</td>
 </tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:110px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>

<table width="100%" border="0"  cellspacing="0" style="margin-top:-400px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/../logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -350px;"  align="center">
  <tr>
  	<td>
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>


17.	SOCIABILIDADE<br/>
Avalia o grau de necessidade do indivíduo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamentos de colaboração e individualismo<br/> e o nível de concessão dependida a outras pessoas.<br/><br/>

18.	AUTO-IMAGEM<br/>
Avalia a forma como o indivíduo é percebido pelo grupo e o seu grau de auto - estima.<br/><br/>


19.	ENERGIA VITAL<br/>
Avalia o nível de vitalidade do indivíduo, revelando-se “estressado” por excesso de trabalho, ou por estar enfrentando algum problema emocional. Também<br/> avalia o nível do clima organizacional, caso haja muitas pessoas com baixo tônus vital.<br/><br/>


20.	REALIZAÇÃO<br/>
Avalia a necessidade do indivíduo em atingir suas metas de vida. Está relacionado às suas realizações do momento.<br/><br/> <br/> 


	</td>
 </tr>
 
 	<tr>
			<td colspan="4">
			
			
<b>INSTRUÇÕES:</b><br/><br/>

A seguir é apresentado o seu resultado APP com base em 20 habilidades/competências pessoais e profissionais. Ele está organizado com as colunas CRITÉRIO, NOTA e AVALIAÇÃO e enumerado de 1 a 20. <br/> <br/> 

Cada CRITÉRIO equivale a uma habilidade/competência e lhe é atribuída uma NOTA de 0 (zero) à 10 (dez)  e seu resultado corresponde a um destes valores.<br/> <br/>  

A coluna AVALIAÇÃO possui um texto personalizado de acordo com a sua NOTA no respectivo CRITÉRIO.<br/> <br/> 

Para facilitar posteriormente sua interpretação são apresentados 2 gráficos para melhor entendimento do seu resultado. Sempre avaliamos como média ideal - a NOTA 7.<br/> <br/> 

Está disponível, também na última página, um quadro que irá lhe fornecer uma visão clara de que competências e habilidades você deve priorizar  para o seu desenvolvimento  pessoal e profissional.<br/> <br/> 

Lembre-se que as habilidades ou competências devem ser priorizadas conforme o cargo e tipo de organização, para melhor atender o perfil do profissional desejado, pois cada situação deve ser customizada às necessidades específicas.
			</td>
		
		</tr>
		<tr>&nbsp;</tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:70%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>
-->

<?}?>



<? if($_REQUEST["orga"] != 999999){?>

<table width="100%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2"  align="center">
  <tr>
  	<td>
<b>APP® - ORIENTAÇÕES PARA INTERPRETAÇÃO DE SEU PERFIL</b><br/><br/>

Os resultados preliminares da pesquisa brasileira com o APP® indicam que, para a amostra pesquisada, nossos profissionais revelam fatores similares ao perfil demandado no mercado global, mas também apresentam especificidades típicas de um povo latino, colonizados por portugueses e fortemente influenciados pela formação religiosa católica.<br/><br/>

Neste sentido, algumas observações são pertinentes com relação aos comportamentos apresentados pelos profissionais brasileiros:<br/><br/>

-	A auto-estima do brasileiro é muito rebaixada e, portanto, apesar de ser um profissional que possui autoconfiança, 83,4% apresentam baixa auto-imagem e não sabem fazer marketing pessoal;<br/><br/>

-	apesar de o cidadão brasileiro ser considerado altamente criativo pela maioria dos escritores, 92,1% dos profissionais segue normas em excesso, bloqueando sua criatividade. Sem dúvida, somos considerados muito criativos e devemos apresentar um alto grau de inventividade, mas parece que deixamos para aplicar todo este potencial fora dos limites das organizações;<br/><br/>

-	87,2% dos profissionais apresentam facilidade para aceitar mudanças e inovações, todavia, 89,1% têm dificuldades para lidar com imprevistos e emergências. Parece que aceitamos bem mudanças, mas não gostamos de improvisação, principalmente os “perfeccionistas”; <br/><br/>

-	o resultado assinalado (traço sob o número) é o ideal e a sua nota corresponde ao seu desempenho atual.<br/><br/>

Além disso, é importante ressaltar que:<br/><br/>

-	O ser humano é único, genuíno e exclusivo;<br/><br/>

-	Cada momento de sua vida o influenciará no desempenho de suas habilidades e competências, todavia a essência de sua personalidade é preservada.<br/><br/>

-	O comportamento humano não pode ser mensurado de forma cartesiana, e apesar de revelarmos indicadores pelo Inventário APP® é necessário compreendermos que as ambigüidades são naturais do ser humano.<br/><br/>


E, finalmente compreendemos que somos todos indivíduos repletos de potencialidades e fragilidades que alimentam o nosso “sabor” pela vida. Enfatize suas potencialidades e estabeleça suas metas pessoais e profissionais com foco e determinação, por meio do autoconhecimento.<br/><br/>

E seja feliz, pois você MERECE!<br/><br/>

<b>Maria Lúcia Rodrigues Corrêa<br/>
Responsável - Equipe APP®<br/>
CRP 1560</b><br/>

	</td>
 </tr>
</table>

<hr style="height: 1px; width: 80%; color: #666666; margin-top:50%;">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<br clear=all style='mso-special-character:line-break;page-break-before:always'>


<table width="100%" border="0"  cellspacing="0" style="margin-top: -90px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -40px;"  align="center">
  <tr>
  	<td>
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>

1.	CAPACIDADE DE PLANEJAMENTO<br/>
Avalia o grau de identificação do indivíduo com a atividade de planejar. Entende-se a capacidade de planejamento como ação de criar recursos para se atingir<br/> os objetivos, definindo as linhas de ação, prazos e meios.<br/><br/>


2.	CAPACIDADE DE ORGANIZAÇÃO<br/>
Avalia a capacidade que o indivíduo possui com aspectos organizativos e com a administração do tempo.<br/><br/>


3.	CAPACIDADE DE ACOMPANHAMENTO<br/>
Avalia a capacidade do indivíduo para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, fornecimento de informações,<br/> dados e orientações.<br/><br/>


4.	ESTILO DE LIDERANÇA<br/>
Avalia o grau de identificação do indivíduo com o papel de líder. Sua capacidade para motivar e agregar equipes, visando a obtenção de resultados e criando<br/> um bom clima de sinergia.<br/><br/>


5.	ESTILO DE COMUNICAÇÃO<br/>
Avalia a capacidade que o indivíduo tem para informar com clareza e objetividade, conseguindo manter o grupo inteirado com relação às mudanças relevantes<br/> em  sua área de trabalho.<br/><br/>


6.	TOMADA DE DECISÃO<br/>
Avalia a prontidão pessoal para o risco. Sua  habilidade para decidir com maior ou menor rapidez os assuntos referentes à sua área de trabalho. Avalia<br/> também o grau de tomada de decisão, rotineira ou estratégica.<br/><br/>


7.	CAPACIDADE DE DELEGAÇÃO<br/>
Avalia o grau de necessidade que o indivíduo tem em trabalhar com detalhes. Sua capacidade em separar as tarefas importantes das não importantes,<br/> conseguindo otimizar o seu tempo e delegar.<br/><br/>


8.	ADMINISTRAÇÃO DO TEMPO<br/>
Avalia a capacidade do indivíduo em  trabalhar com prazos curtos e sob pressão de tempo.<br/><br/>


9.	VOLUME DE TRABALHO<br/>
Avalia o volume de trabalho que o indivíduo está suportando. Se a pessoa necessita trabalhar em excesso, ou se está se sentindo subaproveitado.<br/><br/>


10.	POTENCIAL CRIATIVO E FLEXIBILIDADE<br/>
Avalia o grau de necessidade que o indivíduo tem em seguir normas, regras, valores, metodologias, etc., para a execução de suas tarefas. Não sugere<br/> a ausência de normas, mas sim a utilização de padrões, permitindo a criatividade.<br/><br/>

11.	CAPACIDADE DE PRIORIZAR E TRABALHAR COM IMPREVISTOS<br/>
Avalia o grau de atenção concentrada em um assunto ou tarefa. Sugere se o comportamento é dispersivo e não conclusivo e se consegue trabalhar com<br/> imprevistos e emergências, sem se prejudicar. Avalia também sua capacidade de perceber bem o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	GESTÃO DE MUDANÇAS<br/>
Avalia a necessidade que o indivíduo tem de mudanças e o seu grau de adaptação às situações e pessoas novas. Indica também a rapidez com que o<br/> indivíduo se adapta às inovações.<br/><br/>


13.	RELACIONAMENTO COM SUPERIORES<br/>
Avalia se o indivíduo está se apresentando submisso com a figura de chefia, ou se consegue estabelecer relação de confiança, criando um clima de parceria<br/> e abertura, favorecendo os resultados.<br/><br/>

14.	GESTÃO DE CONFLITOS<br/>
Avalia a forma como o indivíduo reage diante de situações tensas. Se evita conflitos revelando-se passivo nessas ocasiões, ou apresenta-se agressivo para<br/> resolver o problema, mesmo que essa atitude seja inconveniente.<br/><br/>


15.	CONTROLE DAS EMOÇÕES<br/>
Avalia a habilidade do indivíduo em lidar com suas emoções. Se a pessoa explode com facilidade, ou se reprime seus sentimentos. <br/><br/>

16.	AFETIVIDADE<br/>
Avalia o grau de envolvimento do indivíduo com outras pessoas.<br/><br/>




	</td>
 </tr>
</table>


        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<hr style="height: 1px; width: 80%; color: #666666; ">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<br clear=all style='mso-special-character:line-break;page-break-before:always'>

<table width="100%" border="0"  cellspacing="0" style="margin-top:-400px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-top: -350px;"  align="center">
  <tr>
  	<td>
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>


17.	RELACIONAMENTO EM GRUPOS<br/>
Avalia o grau de necessidade do indivíduo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamentos de colaboração e individualismo<br/> e o nível de concessão dependida a outras pessoas.<br/><br/>

18.	IMAGEM PESSOAL<br/>
Avalia a forma como o indivíduo é percebido pelo grupo e o seu grau de auto - estima.<br/><br/>


19.	TÔNUS VITAL<br/>
Avalia o nível de vitalidade do indivíduo, revelando-se “estressado” por excesso de trabalho, ou por estar enfrentando algum problema emocional. Também<br/> avalia o nível do clima organizacional, caso haja muitas pessoas com baixo tônus vital.<br/><br/>


20.	NECESSIDADE DE REALIZAÇÃO<br/>
Avalia a necessidade do indivíduo em atingir suas metas de vida. Está relacionado às suas realizações do momento.<br/><br/> <br/> 


	</td>
 </tr>
 
 	<tr>
			<td colspan="4">
			
			
<b>INSTRUÇÕES:</b><br/><br/>

A seguir é apresentado o seu resultado APP com base em 20 habilidades/competências pessoais e profissionais. Ele está organizado com as colunas CRITÉRIO, NOTA e AVALIAÇÃO e enumerado de 1 a 20. <br/> <br/> 

Cada CRITÉRIO equivale a uma habilidade/competência e lhe é atribuída uma NOTA de 0 (zero) à 10 (dez)  e seu resultado corresponde a um destes valores.<br/> <br/>  

A coluna AVALIAÇÃO possui um texto personalizado de acordo com a sua NOTA no respectivo CRITÉRIO.<br/> <br/> 

Para facilitar posteriormente sua interpretação são apresentados 2 gráficos para melhor entendimento do seu resultado. Sempre avaliamos como média ideal - a NOTA 7.<br/> <br/> 

Está disponível, também na última página, um quadro que irá lhe fornecer uma visão clara de que competências e habilidades você deve priorizar  para o seu desenvolvimento  pessoal e profissional.<br/> <br/> 

Lembre-se que as habilidades ou competências devem ser priorizadas conforme o cargo e tipo de organização, para melhor atender o perfil do profissional desejado, pois cada situação deve ser customizada às necessidades específicas.
			</td>
		
		</tr>
		<tr>&nbsp;</tr>
</table>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:70%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<br clear=all style='mso-special-character:line-break;page-break-before:always'>


<?}?>


<table width="100%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><span style="font-size:8px;"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?></span>
           </td>
          <td width="52%"><span style="font-size:8px;"><strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="1"  align="center">
	
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="9%" nowrap><span class="style17">Critério</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avaliação</span></td>
  </tr>    

  <?php
	$i = 0;
	$linha_arquivo = 1;
//	echo "<p><b>CompetÃªncias:</b></p>";
	while ($i<20){ 
		?>
	
		<tr><td width="2%" valign="top">		
		<? echo ($i+1); ?>
		</td><td width="9%" style="font-size:8.5px; " valign="top">
		<? echo $nome_competencias[$i] . "<br>"; 
		 ?>
		</td><td  width="5%" valign="top" align="center">
		<? echo $nota110 = base10(($i+1),$competencias[$i]); ?>
		</td><td align="left" valign="top" style="font-size:8.5px; font-align:center; width: 100%;"><div style="width: 100%;text-align: justify;">
		<? $texto = feedback(($i+1),$competencias[$i]); ?>
		<p >	
			<? 
				$num_linhas = 0;
				$caracteres = 0; 
			   
			//$novotexto = wordwrap($texto, 100, "<br />");
			echo $texto;
			?>
		</p>
		</div></td></tr>
		<?
		if ($linha_arquivo == 10 && $i < 19) {
		?>
		</table>
		
		<hr style="height: 1px; width: 80%; color: #666666; margin-top:2px">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<br clear=all style='mso-special-character:line-break;page-break-before:always'>
		
<table width="100%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:10px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?></td>
          <td width="52%">  <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="2"  align="center">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="9%" nowrap><span class="style17">Critério</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avaliação</span></td>
  </tr>    

<?
			$linha_arquivo =-2;
		}
		
		
		$total = $total + $competencias[$i];
		$i++;
		$linha_arquivo++;
	}
//	echo "Total = " . $total;
//	echo "<p><b>ConcluÃ­do</b></p>";
}//fim do if
}//fim do if

function base10 ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao, f.base10
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
		
			return $a = mysql_result($sql, 0, "base10");
		

}



function feedback ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao 
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   
			
			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
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
			<p style="margin-top: 5px; margin-left: 20px;"><span style="text-transform:uppercase; font-size:12px;" >Nota Geral - média das 20 competências :<?	echo ($notamedia2/20); ?></span><p>
		
<?}?>
		<div style="width:80%; height: 10px"></div>
		<hr style="height: 1px; width: 80%; color: #666666; margin-top: 25px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
<br clear=all style='mso-special-character:line-break;page-break-before:always'>







<? 	 $codigo_id2 = $codigo_id."grafico2.png"; 
$codigo_id = $codigo_id."grafico.png"; 

?>


		<? if($orga != 999999){ ?>
<table width="100%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!--<p style="margin-top: 0px;"><center><img src="http://appweb.com.br/cms/graficos_vendidos/<?=$codigo_id2?>"/></center></p>
<br/>-->
<br/>
<p style="margin-top: 10px;"><center><img src="http://appweb.com.br/cms/graficos_vendidos/<?=$codigo_id?>" width="560" height="400" /></center></p>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<hr style="height: 1px; width: 80%; color: #666666; margin-top:20px">
		<div style="margin-top: 20px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<br clear=all style='mso-special-character:line-break;page-break-before:always'>
<table width="100%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="http://appweb.com.br/cms/logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<p style="margin-left:10px;">
A tabela a seguir possui 3 colunas sendo Sustentação, Aceitável e Crítico.<br />
Por "Sustentação" entenda pelos "pontos fortes" do candidato que remetem aos fatores de excelência.<br />
Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais. <br />
Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.<br /><br /> 

É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.</p>


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
	<p style="margin-top: 5px; margin-left: 45px;"><span style="text-transform:uppercase; font-size:15px;" >Nota Geral - média das 20 competências :<?	echo ($notamedia/20); ?></span><p>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:30%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		<?}?>
		
		
<script language='JavaScript'>history.go(1);</script>
</body>
</html>

