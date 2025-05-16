<? include("library.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
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
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
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
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>

1.	Capacidade de planejamento<br/>
Avalia a capacidade de planejamento do profissional que é definida como a ação para se criar recursos para atingir os objetivos.<br/><br/>


2.	Capacidade de organização<br/>
Avalia a capacidade que o indivíduo apresenta em relação a aspectos organizativos e à administração do tempo. <br/><br/>


3.	Capacidade de Acompanhamento (Liderança COACH)<br/>
Avalia a capacidade que o indivíduo apresenta para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, informações, feedbacks e orientações.<br/><br/>


4.	Estilo de liderança<br/>
Avalia o grau de identificação do indivíduo com o papel de líder e sua capacidade para motivar e agregar equipes, visando à obtenção de resultados e criação de um bom clima de sinergia.<br/><br/>


5.	Estilo de comunicação<br/>
Avalia a capacidade que o indivíduo tem para informar com clareza e objetividade.<br/><br/>


6.	Tomada de decisão<br/>
Avalia a prontidão pessoal para o risco. Avalia também sua habilidade para decidir com maior ou menor rapidez, se há autonomia para decidir ou se há omissão.<br/><br/>


7.	Capacidade de delegação<br/>
Avalia o grau de necessidade do indivíduo em trabalhar com detalhes e sua capacidade de delegação.<br/><br/>


8.	Administração do tempo<br/>
Avalia a capacidade do indivíduo em trabalhar com prazos curtos e sob pressão de tempo.<br/><br/>


9.	Volume de trabalho<br/>
Avalia o volume de trabalho que o profissional suporta, se ele necessita trabalhar em excesso, ou se está se sentindo subaproveitado.<br/><br/>


10.	Potencial criativo e flexibilidade<br/>
Avalia a necessidade que o indivíduo tem em seguir normas, regras, procedimentos, metodologias, etc. ou sua necessidade em trabalhar com liberdade de expressão para criar.<br/><br/>

11.	Capacidade de priorizar e trabalhar com imprevistos<br/>
Avalia o grau de atenção concentrada e indica se o comportamento é dispersivo ou se a pessoa consegue estabelecer suas prioridades e trabalhar com imprevistos e emergências. Mensura também sua capacidade em perceber o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	Gestão de mudanças<br/>
Avalia a necessidade que o profissional apresenta em aceitar e adaptar-se às mudanças e inovações. <br/><br/>


13.	Relacionamento com superiores<br/>
Avalia se o profissional é submisso ou evita seus superiores, ou se consegue estabelecer uma relação de confiança, criando um clima de parceria e abertura.<br/><br/>

14.	Gestão de conflitos<br/>
Avalia a forma como o profissional reage diante de situações tensas. Se evita conflitos revelando-se passivo, ou apresenta-se agressivo mediante estas situações.<br/><br/>


15.	Controle das emoções<br/>
Avalia a habilidade do indivíduo em lidar com suas emoções. Se explode com facilidade, ou se reprime seus sentimentos. <br/><br/>

16.	Relacionamento afetivo<br/>
Avalia o grau de envolvimento do profissional com outras pessoas. Se consegue dividir seus problemas, se é muito reservado, ou se faz muita concessão para as pessoas de sua confiança.
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
<b>APP® - ORIENTAÇÕES PARA INTERPRETAÇÃO DE SEU PERFIL</b><br/><br/>

Os resultados preliminares da pesquisa brasileira com o APP® indicam que, para a amostra pesquisada, nossos profissionais revelam fatores similares ao perfil<br/> demandado no mercado global, mas também apresentam especificidades típicas de um povo latino, colonizados por portugueses e fortemente influenciados<br/> pela formação religiosa católica.<br/><br/>

Neste sentido, algumas observações são pertinentes com relação aos comportamentos apresentados pelos profissionais brasileiros:<br/><br/>

-	A autoestima do brasileiro é muito rebaixada e, portanto, apesar de ser um profissional que possui autoconfiança, 53,8% apresentam baixa autoimagem e <br/> não sabem fazer marketing pessoal;<br/><br/> 

-	apesar de o cidadão brasileiro ser considerado altamente criativo pela maioria dos escritores, 93,1% dos profissionais segue normas em excesso, bloqueando<br/> sua criatividade. Sem dúvida, somos considerados muito criativos e devemos apresentar um alto grau de inventividade, mas parece que deixamos para aplicar<br/> todo este potencial fora dos limites das organizações;<br/><br/>

-	78,4% dos profissionais apresentam facilidade para aceitar mudanças e inovações, todavia, 52,8% têm dificuldades para lidar com imprevistos e emergências.<br/> Parece que aceitamos bem mudanças, mas não gostamos de improvisação, principalmente os “perfeccionistas”; <br/><br/>

-	O resultado assinalado (traço sob o número) é o ideal e a sua nota  é o número que está ao lado e corresponde ao seu desempenho atual.<br/><br/>

Além disso, é importante ressaltar que:<br/><br/>

-	O ser humano é único, genuíno e exclusivo;<br/><br/>

-	Cada momento de sua vida o influenciará no desempenho de suas habilidades e competências, todavia a essência de sua personalidade é preservada.<br/><br/>

-	O comportamento humano não pode ser mensurado de forma cartesiana, e apesar de revelarmos indicadores pelo Inventário APP® é necessário<br/> compreendermos que as ambigüidades são naturais do ser humano.<br/><br/>


E, finalmente é preciso entender que somos todos indivíduos repletos de potencialidades e fragilidades. Enfatize<br/> suas potencialidades e estabeleça suas metas pessoais e profissionais com foco e determinação, por meio do autoconhecimento.<br/><br/>

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
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>

1.	CAPACIDADE DE PLANEJAMENTO<br/>
Avalia a capacidade de planejamento do profissional que é definida como a ação para se criar recursos para atingir os objetivos.<br/><br/>


2.	CAPACIDADE DE ORGANIZAÇÃO<br/>
Avalia a capacidade que o indivíduo apresenta em relação a aspectos organizativos e à administração do tempo. <br/><br/>


3.	CAPACIDADE DE ACOMPANHAMENTO (LIDERANÇA COACH)<br/>
Avalia a capacidade que o indivíduo apresenta para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, <br/>informações, feedbacks e orientações.<br/><br/>


4.	ESTILO DE LIDERANÇA<br/>
Avalia o grau de identificação do indivíduo com o papel de líder e sua capacidade para motivar e agregar equipes, visando à obtenção de resultados e <br/>criação de um bom clima de sinergia.<br/><br/>


5.	ESTILO DE COMUNICAÇÃO<br/>
Avalia a capacidade que o indivíduo tem para informar com clareza e objetividade.<br/><br/>


6.	TOMADA DE DECISÃO<br/>
Avalia a prontidão pessoal para o risco. Avalia também sua habilidade para decidir com maior ou menor rapidez, se há autonomia para decidir ou <br/>se há omissão.<br/><br/>


7.	CAPACIDADE DE DELEGAÇÃO<br/>
Avalia o grau de necessidade do indivíduo em trabalhar com detalhes e sua capacidade de delegação.<br/><br/>


8.	ADMINISTRAÇÃO DO TEMPO<br/>
Avalia a capacidade do indivíduo em trabalhar com prazos curtos e sob pressão de tempo.<br/><br/>


9.	VOLUME DE TRABALHO<br/>
Avalia o volume de trabalho que o profissional suporta, se ele necessita trabalhar em excesso, ou se está se sentindo subaproveitado.<br/><br/>


10.	POTENCIAL CRIATIVO E FLEXIBILIDADE<br/>
Avalia a necessidade que o indivíduo tem em seguir normas, regras, procedimentos, metodologias, etc. ou sua necessidade em trabalhar com <br/>liberdade de expressão para criar.<br/><br/>

11.	CAPACIDADE DE PRIORIZAR E TRABALHAR COM IMPREVISTOS<br/>
Avalia o grau de atenção concentrada e indica se o comportamento é dispersivo ou se a pessoa consegue estabelecer suas prioridades e trabalhar <br/>com imprevistos e emergências. Mensura também sua capacidade em perceber o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>

12.	GESTÃO DE MUDANÇAS<br/>
Avalia a necessidade que o profissional apresenta em aceitar e adaptar-se às mudanças e inovações. <br/><br/>


13.	RELACIONAMENTO COM SUPERIORES<br/>
Avalia se o profissional é submisso ou evita seus superiores, ou se consegue estabelecer uma relação de confiança, criando um clima de parceria e <br/>abertura.<br/><br/>

14.	GESTÃO DE CONFLITOS<br/>
Avalia a forma como o profissional reage diante de situações tensas. Se evita conflitos revelando-se passivo, ou apresenta-se agressivo mediante <br/>estas situações.<br/><br/>


15.	CONTROLE DAS EMOÇÕES<br/>
Avalia a habilidade do indivíduo em lidar com suas emoções. Se explode com facilidade, ou se reprime seus sentimentos.<br/><br/>

16.	AFETIVIDADE<br/>
Avalia o grau de envolvimento do profissional com outras pessoas. Se consegue dividir seus problemas, se é muito reservado, ou se faz muita <br/>concessão para as pessoas de sua confiança.<br/><br/>
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
<b>APP® - DEFINIÇÕES DAS HABILIDADES E COMPETÊNCIAS</b><br/><br/>


17.	RELACIONAMENTO EM GRUPOS<br/>
Avalia a necessidade do indivíduo em se integrar, pertencer, dar e receber apoio de grupos. Revela comportamentos de colaboração e o nível de concessão feita a outras pessoas para agradar o grupo.<br/><br/>

18.	IMAGEM PESSOAL<br/>
Avalia a forma como o indivíduo é percebido e o seu grau de autoestima. Se é autoconfiante, ou tem dificuldades  para fazer seu marketing pessoal, ou se é considerado “exibicionista”.<br/><br/>


19.	TÔNUS VITAL<br/>
Avalia o nível de vitalidade do indivíduo, se na média, eufórico,  ou se está “estressado” por excesso de trabalho ou problemas pessoais.  O tônus vital pode sofrer impactos em virtude do grau de motivação do profissional.<br/><br/>


20.	NECESSIDADE DE REALIZAÇÃO<br/>
Avalia a necessidade do indivíduo em atingir suas metas de vida pessoais e profissionais e seu grau de motivação em relação aos seus  desafios.<br/><br/> <br/> 


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

