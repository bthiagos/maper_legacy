<? 
//ob_start(); ?>
<?php include("library.php"); ?>
<?php include("conn.php"); ?>

<?

///session_start();
$where = str_ireplace('sp',' ',$_REQUEST["wherea"]);
$where = str_ireplace('ig','=',$where);
    

$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");

///echo $where."<br>";
			$sql2 = "SELECT
				organizacoes.nome as orga,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio,
				aplicacoes.respostas
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where 
				ORDER BY organizacoes.nome desc
				";
				
				//echo $sql;
				//break;
				$result2 = mysql_query($sql2);
				$nPessoas = mysql_num_rows($result2);
				
				$sql = "SELECT
				organizacoes.nome as orga,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where GROUP BY
				grupos.id
				ORDER BY organizacoes.nome desc
				";
				
				//echo $sql;
				//break;
				$result = mysql_query($sql);
				$y=1;
				while ($linha = mysql_fetch_assoc($result)) {
					$grupos .= "<br />".$linha["orga"]."<br />".$linha["grupo"];
				
				}	
				
				while($linha2 = mysql_fetch_array($result2)){
						$i++;
					$i = $j = $total = 0; $login =0;
					$Opcao = "";
					$id_competencia = "";
					$sql = "";
					$row = "";				
					$competencias [20];
				
				while ($i<20){
					$competencias[$i]=0;
					$i++;
				}
				
				$nome_competencias[20];
				$pGabarito = "";
				$pGabarito = $linha2["respostas"];		
				

					if (strlen($pGabarito)==100){
	
					   		$sql2 = " 
				       		SELECT c.descricao 
				       		FROM  competencias c
					   		ORDER BY c.ordem ASC";   
				
							//EXECUTA A QUERY               
							$sql2 = mysql_query($sql2);       
							$row = mysql_num_rows($sql2) or die("erro na busca dos nomes das competÃªncias");    
							
							for ($i=0; $i<$row; $i++){
				   				$nome_competencias[$i] = htmlentities (mysql_result($sql2, $i, "descricao"));
							}
				
				
							$i = 0;
							while ($i<100){
								
								$Opcao = $pGabarito[$i];
								
								if (strcmp($Opcao, "a") || strcmp($Opcao, "b")){
									//QUERY  
							   		$sql3 = " 
						       		SELECT c.ordem 
						       		FROM  questoes q, competencias c
							   		WHERE q.competencia_id=c.competencias_id and q.ordem = ". ($i+1) . " and q.sequencia like \"" . $Opcao . "\"";   
						
									//EXECUTA A QUERY               
									$sql3 = mysql_query($sql3);       
									$row = mysql_num_rows($sql3) or die("erro na busca das questÃµes");    
									
						   			$id_competencia  = mysql_result($sql3, 0, "ordem");
									$competencias[$id_competencia-1]++;
						
								} //fim do if
								$i++;
							}		 //fim do while
																
					}
					$i = 0;
					while ($i<20){						 
						 $totaCompetencias[$y][$i] = $competencias[$i];					 
						 $i++;
					}
					
					$y++;	
				}
				
				$i = 0;			
				while($i<20){
					for($a=0;$a<=$nPessoas;$a++){
						$graCOMPETENCIAS[$i] = $graCOMPETENCIAS[$i] + $totaCompetencias[$a][$i];
					}
					$i++;
				}
				
				$i=0;	
				while($i<20){
						$graCOMPETENCIA[$i] = round($graCOMPETENCIAS[$i]/$nPessoas);	
						// $graCOMPETENCIA[$i]."<br>";
						$i++;	
				}

			$datay2 = array(6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,6,4,6,7);
			$datay3 = array(4,4,6,6,5,6,0,5,4,0,4,5,4,5,4,3,4,4,5,5);		
				
			$i = 0;
			while ($i<=20){
					$res=0;
					$nota110 = $graCOMPETENCIA[$i];
					
					
					if($nota110 >= $datay3[$i] and $nota110 <= $datay2[$i]){
						$tabela_sustencao .= "<tr><td style=\"font-size:9px;\">".
						$datax[$i]
						."</td></tr>";
					}
					
					if($nota110 < $datay3[$i]){
						$res = $datay3[$i] - $nota110;
						if($res == 1){
							$tabela_aceitavel .= "<tr><td style=\"font-size:9px;\">".
							$datax[$i]
							."</td></tr>";
						}else{							
							$tabela_critico .= "<tr><td style=\"font-size:9px;\">".
							$datax[$i]
							."</td></tr>";
						}
					}elseif($nota110 > $datay2[$i]){
						$res = $nota110 - $datay2[$i];
						if($res == 1){
							$tabela_aceitavel .= "<tr><td style=\"font-size:9px;\">".
							$datax[$i]
							."</td></tr>";
						}else{							
							$tabela_critico .= "<tr><td style=\"font-size:9px;\">".
							$datax[$i]
							."</td></tr>";
						}
					}
					
								
				
				$i++;
			}
		
				
									
?>
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


<!------    PLANEJAMENTO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    			<h1> 1	- Capacidade de Planejamento</h4>
    		</td>
    	</tr>	
    	</table>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia o grau de identificação do indivíduo com a atividade de planejar. Entende-se planejar com ação de criar recursos para se atingir os objetivos, definindo <br /> as linhas de ação, prazos e meios.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	
	<p>
	<img src="graficos_grupos/planejamento.png" border="0">

	</p>
	
	</td>
</tr>
</table>
</p>
<!------    PLANEJAMENTO     ------>

<div class="folha">&nbsp;</div>


<!------    ORGANIZAÇAO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left" width="75%">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    		<h1> 2 - Capacidade de Organização</h4>
    		</td>
    	</tr>	
    	</table>
    </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia a capacidade que o indivíduo possui com aspectos organizativos e com a administração do tempo
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	
	<p>
	<img src="graficos_grupos/organizacao.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    ORGANIZAÇAO     ------>

<div class="folha">&nbsp;</div>


<!------    ACOMPANHAMENTO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    		<h1> 3 - Capacidade de acompanhamento</h4>
	    	</td>
	 	 </tr>
	 </table> 
 	</td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia a capacidade do indivíduo para acompanhar e promover o desenvolvimento de sua equipe, através de treinamentos, fornecimento de informações, dados <br /> e orientações.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	
	<p>
	<img src="graficos_grupos/acompanhamento.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    ACOMPANHAMENTO     ------>

<div class="folha">&nbsp;</div>

<!------    LIDERANÇA    ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    		<h1> 4 - Estilo de liderança</h4>
		    </td>
		 </tr>
		</table>
  </td>
  </tr>
 </table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">
 
  <tr>
  	<td colspan="2">
  		Avalia o grau de identificação do indivíduo com o papel de líder.<br>
  		Sua capacidade para motivar e agregar equipes, visando a obtenção de resultados e criando um bom clima de sinergia.
  	</td>
  </tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
	<td align="center">
	
	<p>
	<img src="graficos_grupos/lideranca.png" border="0">

	</p>
	
	</td>
</tr>
</table>	
</p>
<!------    LIDERANÇA    ------>
<div class="folha">&nbsp;</div>
<!------ COMUNICAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
	    	<tr>
	    		<td align="left">
	    			<b>Organização/Grupo</b>: <?=$grupos?>
	    		</td>
	    		
	    		<td >
	    			<b>Data</b>:  <? echo date("d/m/Y")?>
	    		</td>
	    		<td >
	    			<b>Nº Pessoas</b>: <?=$nPessoas?>
	    		</td>
	    	</tr>
	    	
	    	<tr>
	    		<td colspan="3" width="100%" align="center">
	<h1>5 - Estilo de comunicação</h4>
				</td>
			</tr>
		</table>	
	
	</td>
	</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a capacidade que o indivíduo tem para informar com clareza e objetividade, conseguindo manter o grupo inteirado com relação às mudanças em seu local de trabalho.
</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">


<p>
<img src="graficos_grupos/comunicacao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ COMUNICAÇÃO ------>
<div class="folha">&nbsp;</div>

<!------ DECISÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>6 - Tomada de decisão</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a prontidão pessoal para o risco. Sua habilidade para decidir com maior ou menor rapidez os assuntos referentes a sua área de trabalho. Avalia também <br /> o grau de tomada de decisão, rotineira ou estratégica.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">

<p>
<img src="graficos_grupos/decisao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ DECISÃO ------>
<div class="folha">&nbsp;</div>

<!------ DETALHISMO/DELEGAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>7 - Capacidade de delegação</h4>
</td>
</tr>
</table></td>
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

<p>
<img src="graficos_grupos/detalhismo.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ DETALHISMO/DELEGAÇÃO ------>
<div class="folha">&nbsp;</div>
<!------ TEMPO DE EXECUÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>8 - Administração do tempo</h4>
</td>
</tr>
</table>


</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a capacidade do indivíduo em trabalhar com prazos curtos e sob pressão de tempo.
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/tempoexecucao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ TEMPO DE EXECUÇÃO ------>
<div class="folha">&nbsp;</div>

<!------ INTENSIDADE OPERACIONAL ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>9 - Volume de trabalho</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o volume de trabalho que o indivíduo está suportando e se ele necessita trabalhar em excesso, ou se está se sentindo sub-aproveitado.
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>10 - Potencial criativo e flexibilidade</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de necessidade que o indivíduo tem em seguir normas, regras, valores, metodologias, etc., para a execução de suas tarefas. Avalia sua necessidade em criar e trabalhar com liberdade de expressão.
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/criatividade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ FLEXIBILIDADE - CRIATIVIDADE ------>
<div class="folha">&nbsp;</div>

<!------ PERCEPÇÃO / PRIORIZAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>11 - Capacidade de priorizar e trabalhar com imprevistos</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de atenção concentrada em um assunto ou tarefa. Sugere se o comportamento é dispersivo e não conclusivo e se o indivíduo consegue trabalhar <br /> com imprevistos e emergências sem se prejudicar. Avalia também sua capacidade em perceber bem o conjunto e mudar suas prioridades, conforme a demanda.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/percepsao.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ PERCEPÇÃO / PRIORIZAÇÃO ------>
<div class="folha">&nbsp;</div>
<!------ ADAPTABILIDADE A MUNDANÇAS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>12 - Gestão de mudanças</h4>
</td>
</tr>
</table>

</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a necessidade que o indivíduo tem de mudanças e o seu grau de adaptação à situação e pessoas novas. Indica também a rapidez com que o indivíduo se adapta à inovações.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/mudancas.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ADAPTABILIDADE A MUNDANÇAS ------>
<div class="folha">&nbsp;</div>

<!------ RELAÇÃO COM AUTORIDADE ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>13 - Relacionamento com superiores</h4>
</td>
</tr>
</table>

</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia se o indivíduo está se apresentando submisso com a figura de chefia, ou se consegue estabelecer uma relação de confiança, criando um clima <br /> de parceria e abertura.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/autoridade.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ RELAÇÃO COM AUTORIDADE ------>
<div class="folha">&nbsp;</div>

<!------ ADMINISTRAÇÃO DE CONFLITOS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>14 - Gestão de conflitos</h4>
		</td>
		</tr>
		</table>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a forma como o indivíduo reage diante de situações tensas.Se evita conflitos revelando-se passivo nessas ocasiões, ou apresentam-se agressivos para <br /> resolver o problemam, mesmo que essa atitude seja incoveniente.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/administracaodeconflitos.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ADMINISTRAÇÃO DE CONFLITOS ------>
<div class="folha">&nbsp;</div>

<!------ CONTROLE EMOCIONAL ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>15 - Controle das emoções</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a habilidade do indivíduo em lidar com suas emoções. Se explode com facilidade, ou se reprime suas sentimentos.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>16 - Relacionamento afetivo</h4>
</td>
</tr>
</table>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de envolvimento do indivíduo com outras pessoas.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>17 - Relacionamento em grupos</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o grau de necessidade do indivíduo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamento de colaboração e individualismo <br /> e o nível de concessão dispendida a outra pessoa.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>18 - Imagem pessoal</h4>
</td>
</tr>
</table>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a forma como o indivíduo é percebido pelo grupo e o seu grau de auto-estima.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>19 - Tônus vital</h4>
</td>
</tr>
</table></td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia o nível de vitalidade do indivíduo, revelando-se "estressado" por excesso de trabalho, ou por estar enfrentando algum problema emocional. <br /> Também avalia o nível do clima organizacional, caso haja muitas pessoas com baixo tônus vital.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/energiavital.png" border="0">

</p>

</td>
</tr>
</table>
</p>
<!------ ENERGIA VITAL ------>
<div class="folha">&nbsp;</div>
<!------ REALIZAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>20 - Necessidade de realização</h4>
</td>
</tr>
</table>
</td>
</tr>
</table>


<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

<tr>
<td colspan="2">
Avalia a necessidade do indivíduo em atingir suas metas de vida. Está relacionado às suas realizações do momento.</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/realizacao.png" border="0">
</p>

</td>
</tr>
</table>
</p>
<!------ REALIZAÇÃO ------>

<div class="folha">&nbsp;</div>
<!------ REALIZAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	</table>
</td>
</tr>
</table>
</p>

<p>
<table border="0" width="100%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">
<p>
<img src="graficos_grupos/grupos2.png" border="0">
</p>

</td>
</tr>
</table>
</p>
<!------ REALIZAÇÃO ------>

<div class="folha">&nbsp;</div>
<!------ REALIZAÇÃO ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organização/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>Nº Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	</table>
</td>
</tr>
</table>
</p>

<p>

<div style="margin-left:40px;">

<table border="0" width="100%">
	<tr>
		<td valign="top">
			<table style="border: 4px solid #0000ff;" width="70%">
				<tr>
					<td align="center"><span style="color:#0000ff; text-transform:uppercase; font-size:14px;" ><u><b>Sustentação</b></u></span></td>
					
				</tr>
				<?=$tabela_sustencao?>
			
			</table>
		</td>

		<td valign="top">
			<table style="border: 4px solid #ffff00;" width="70%">
				<tr>
					<td align="center"><span style="color:#ffff00; text-transform:uppercase; font-size:14px;" ><u><b>Aceitável</b></u></span></td>
					
				</tr>
				<?=$tabela_aceitavel?>
			
			</table>
		</td>
		
		<td valign="top">
			<table style="border: 4px solid #ff0000;" width="70%">
				<tr>
					<td align="center"><span style="color:#ff0000; text-transform:uppercase; font-size:14px;" ><u><b>Crítico</b></u></span></td>
				</tr>
				
				<?=$tabela_critico?>
			
			</table>	

		</td>
	</tr>
</table>
</div>
</p>
<!------ REALIZAÇÃO ------>

</body>
</html>
		