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

//CONECTA AO MYSQL                     

include("conn.php");

$sql = " SELECT * FROM aplicacoes WHERE id=".$_REQUEST["id"]; 

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

			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    

			

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

			$row = mysql_num_rows($sql) or die("erro na busca das questões");    

			

   			$id_competencia  = mysql_result($sql, 0, "ordem");

			$competencias[$id_competencia-1]++;



		} //fim do if

		$i++;

	} //fim do while

	

?>

</p>





<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);

	background-repeat: repeat-y;"" bordercolor="#000000" align="center">

  <tr>

    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>

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

            <strong>CPF: </strong><?php echo $cpf;?>

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



1.	PLANEJAMENTO<br/>

Avalia o grau de identifica��o do indiv�duo com a atividade de planejar. Entende-se a capacidade de planejamento como a��o de criar recursos para se atingir<br/> os objetivos, definindo as linhas de a��o, prazos e meios.<br/><br/>





2.	ORGANIZA��O<br/>

Avalia a capacidade que o indiv�duo possui com aspectos organizativos e com a administra��o do tempo.<br/><br/>





3.	ACOMPANHAMENTO<br/>

Avalia a capacidade do indiv�duo para acompanhar e promover o desenvolvimento de sua equipe, por meio de treinamentos, fornecimento de informa��es,<br/> dados e orienta��es.<br/><br/>





4.	LIDERAN�A<br/>

Avalia o grau de identifica��o do indiv�duo com o papel de l�der. Sua capacidade para motivar e agregar equipes, visando a obten��o de resultados e criando<br/> um bom clima de sinergia.<br/><br/>





5.	COMUNICA��O<br/>

Avalia a capacidade que o indiv�duo tem para informar com clareza e objetividade, conseguindo manter o grupo inteirado com rela��o �s mudan�as relevantes<br/> em  sua �rea de trabalho.<br/><br/>





6.	DECIS�O<br/>

Avalia a prontid�o pessoal para o risco. Sua  habilidade para decidir com maior ou menor rapidez os assuntos referentes � sua �rea de trabalho. Avalia<br/> tamb�m o grau de tomada de decis�o, rotineira ou estrat�gica.<br/><br/>





7.	DETALHISMO/DELEGA��O<br/>

Avalia o grau de necessidade que o indiv�duo tem em trabalhar com detalhes. Sua capacidade em separar as tarefas importantes das n�o importantes,<br/> conseguindo otimizar o seu tempo e delegar.<br/><br/>





8.	TEMPO DE EXECU��O<br/>

Avalia a capacidade do indiv�duo em  trabalhar com prazos curtos e sob press�o de tempo.<br/><br/>





9.	INTENSIDADE OPERACIONAL<br/>

Avalia o volume de trabalho que o indiv�duo est� suportando. Se a pessoa necessita trabalhar em excesso, ou se est� se sentindo subaproveitado.<br/><br/>





10.	FLEXIBILIDADE - CRIATIVIDADE<br/>

Avalia o grau de necessidade que o indiv�duo tem em seguir normas, regras, valores, metodologias, etc., para a execu��o de suas tarefas. N�o sugere<br/> a aus�ncia de normas, mas sim a utiliza��o de padr�es, permitindo a criatividade.<br/><br/>



11.	PERCEP��O / PRIORIZA��O<br/>

Avalia o grau de aten��o concentrada em um assunto ou tarefa. Sugere se o comportamento � dispersivo e n�o conclusivo e se consegue trabalhar com<br/> imprevistos e emerg�ncias, sem se prejudicar. Avalia tamb�m sua capacidade de perceber bem o conjunto e mudar suas prioridades, conforme a demanda.<br/><br/>



12.	ADAPTABILIDADE A MUDAN�AS<br/>

Avalia a necessidade que o indiv�duo tem de mudan�as e o seu grau de adapta��o �s situa��es e pessoas novas. Indica tamb�m a rapidez com que o<br/> indiv�duo se adapta �s inova��es.<br/><br/>





13.	RELA��O COM AUTORIDADE<br/>

Avalia se o indiv�duo est� se apresentando submisso com a figura de chefia, ou se consegue estabelecer rela��o de confian�a, criando um clima de parceria<br/> e abertura, favorecendo os resultados.<br/><br/>



14.	ADMINISTRA��O DE CONFLITOS<br/>

Avalia a forma como o indiv�duo reage diante de situa��es tensas. Se evita conflitos revelando-se passivo nessas ocasi�es, ou apresenta-se agressivo para<br/> resolver o problema, mesmo que essa atitude seja inconveniente.<br/><br/>





15.	CONTROLE EMOCIONAL<br/>

Avalia a habilidade do indiv�duo em lidar com suas emo��es. Se a pessoa explode com facilidade, ou se reprime seus sentimentos. <br/><br/>



16.	AFETIVIDADE<br/>

Avalia o grau de envolvimento do indiv�duo com outras pessoas.<br/><br/>

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

            <strong>CPF: </strong><?php echo $cpf;?>

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

      <p><b>APP� - DEFINI��ES DAS HABILIDADES E COMPET�NCIAS</b><br/><br/>
        
        
        
        
        
        17.	SOCIABILIDADE<br/>
        
        Avalia o grau de necessidade do indiv�duo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamentos de colabora��o e individualismo<br/> e o n�vel de concess�o dependida a outras pessoas.<br/><br/>
        
        
        
        18.	AUTO-IMAGEM<br/>
        
        Avalia a forma como o indiv�duo � percebido pelo grupo e o seu grau de auto - estima.<br/><br/>
        
        
        
        
        
        19.	ENERGIA VITAL<br/>
        
        Avalia o n�vel de vitalidade do indiv�duo, revelando-se �estressado� por excesso de trabalho, ou por estar enfrentando algum problema emocional. Tamb�m<br/> avalia o n�vel do clima organizacional, caso haja muitas pessoas com baixo t�nus vital.<br/><br/>
        
        
        
        
        
        20.	REALIZA��O<br/>
        
      Avalia a necessidade do indiv�duo em atingir suas metas de vida. Est� relacionado �s suas realiza��es do momento.</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><b>INSTRU&Ccedil;&Otilde;ES:</b><br/>
        <br/>
A seguir &eacute; apresentado o seu resultado APP com base em 20 habilidades/compet&ecirc;ncias pessoais e profissionais. Ele est&aacute; organizado com as colunas CRIT&Eacute;RIO, NOTA e AVALIA&Ccedil;&Atilde;O e enumerado de 1 a 20. <br/>
<br/>
Cada CRIT&Eacute;RIO equivale a uma habilidade/compet&ecirc;ncia e lhe &eacute; atribu&iacute;da uma NOTA de 0 (zero) &agrave; 10 (dez)  e seu resultado corresponde a um destes valores.<br/>
<br/>
A coluna AVALIA&Ccedil;&Atilde;O possui um texto personalizado de acordo com a sua NOTA no respectivo CRIT&Eacute;RIO.<br/>
<br/>
Para facilitar posteriormente sua interpreta&ccedil;&atilde;o s&atilde;o apresentados 2 gr&aacute;ficos para melhor entendimento do seu resultado. Sempre avaliamos como m&eacute;dia ideal - a NOTA 7.<br/>
<br/>
Est&aacute; dispon&iacute;vel, tamb&eacute;m na &uacute;ltima p&aacute;gina, um quadro que ir&aacute; lhe fornecer uma vis&atilde;o clara de que compet&ecirc;ncias e habilidades voc&ecirc; deve priorizar  para o seu desenvolvimento  pessoal e profissional.<br/>
<br/>
Lembre-se que as habilidades ou compet&ecirc;ncias devem ser priorizadas conforme o cargo e tipo de organiza&ccedil;&atilde;o, para melhor atender o perfil do profissional desejado, pois cada situa&ccedil;&atilde;o deve ser customizada &agrave;s necessidades espec&iacute;ficas. <br/>
        <br/> 
        <br/>
    </p></td>

 </tr>

</table>







		<hr style="height: 1px; width: 80%; color: #666666; margin-top:70%">

		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>

<div class="folha">&nbsp;</div>















<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">

  <tr>

    <td width="19%"><img src="../logo_appweb2.jpg" style="margin-top: 0px"/></td>

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





<table width="90%" border="0" cellspacing="0" cellpadding="1"  align="center">

		<tr>

			<td colspan="4">&nbsp;</td>

		

		</tr>

  <tr>

    <td width="20">&nbsp;</td>

    <td width="70" nowrap><span class="style17">Crit�rio</span></td>

    <td width="30" align="center"><span class="style17">Nota</span></td>

    <td align="left"><span class="style17"> Avalia��o</span></td>

  </tr>    



  <?php

	$i = 0;

	$linha_arquivo = 1;

//	echo "<p><b>Competências:</b></p>";

	while ($i<20){ 

		?>

	

		<tr><td width="20" valign="top">		

		<? echo ($i+1); ?>

		</td><td width="70" valign="top" style="font-size:8px; ">

		<? echo $nome_competencias[$i] ?>

		</td><td  width="20" align="center" valign="top"><? echo $nota110 = base10(($i+1),$competencias[$i]); ?></td><td align="left" valign="top" style="font-size:8px; font-align:center;"><div style="width: 100%"><? $texto = feedback(($i+1),$competencias[$i]); ?>

		<p>	

			<? 

				$num_linhas = 0;

				$caracteres = 0; 

			   

			$novotexto = wordwrap($texto, 100, "<br />");

			echo $novotexto;

			?>

		</p>

  </div></td></tr>

		<?

		if ($linha_arquivo == 8 && $i < 19) {

		?>

		</table>

		

<hr style="height: 1px; width: 80%; color: #666666; margin-top:2px">

		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>

		

		

		<div class="folha">&nbsp;</div>

		

<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:10px; border: 1px #000000 solid; background-image: url(fun_table.gif);

	background-repeat: repeat-y;"">

  <tr>

    <td width="19%"><img src="../logo_appweb2.jpg"/></td>

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

		<div style="width:80%; height: 10px"></div>

		<hr style="height: 1px; width: 80%; color: #666666; margin-top: 40px">

		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>

		

<div class="folha">&nbsp;</div>















<? 	 $codigo_id2 = $codigo_id."grafico2.png"; 

$codigo_id = $codigo_id."grafico.png"; 



?>





		<? if($orga != 999999){ ?>

<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);

	background-repeat: repeat-y;"" bordercolor="#000000" align="center">

  <tr>

    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>

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



<br/><br/>

<p style="margin-top: 0px;"><center><img src="graficos_vendidos/<?=$codigo_id2?>"/></center></p>



<br/><br/>

<p style="margin-top: 10px;"><center><img src="graficos_vendidos/<?=$codigo_id?>"/></center></p>



		<hr style="height: 1px; width: 80%; color: #666666; margin-top:110px">

		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>

<div class="folha">&nbsp;</div>







		

<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);

	background-repeat: repeat-y;"" bordercolor="#000000" align="center">

  <tr>

    <td width="19%"><img src="../logo_appweb2.jpg" width="159" height="65" /></td>

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





<p style="margin-top: 10px; margin-left: 25px;"><? include("tabela2_vendido.php"); ?></p>





		<hr style="height: 1px; width: 80%; color: #666666; margin-top:30%">

		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>

		<?}?>

<script language='JavaScript'>history.go(1);</script>

</body>

</html>

