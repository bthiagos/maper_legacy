
<?php include("library.php"); ?>
<?php include("conn.php"); ?>
<?
$where = str_ireplace('space',' ',$_REQUEST["wherea"]);
$where = str_ireplace('igual','=',$where);


$datax=array("Capacidade de planejamento","Capacidade de organiza��o","Capacidade de acompanhamento","Estilo de lideran�a","Estilo de comunica��o","Tomada de decis�o","Capacidade de delega��o","Administra��o do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gest�o de mudan�as","Relacionamento com superiores","Gest�o de conflitos","Controle das emo��es","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","T�nus vital","Necessidade de realiza��o");

///echo $where."<br>";
$sql2 = "SELECT gerador_tickets_pedidos.nome_cliente,
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.cargo,
				aplicacoes_commit.ticket,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				aplicacoes_commit.status_envio
				FROM
				aplicacoes_commit
				INNER JOIN gerador_tickets ON aplicacoes_commit.ticket = gerador_tickets.numero_ticket INNER JOIN gerador_tickets_pedidos ON gerador_tickets.num_pedido = gerador_tickets_pedidos.id $where 
				";
				
				//echo $sql;
				//break;
				$result2 = mysql_query($sql2);
				$nPessoas = mysql_num_rows($result2);
				
				$sql = "SELECT gerador_tickets_pedidos.nome_cliente,
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.cargo,
				aplicacoes_commit.ticket,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				aplicacoes_commit.status_envio
				FROM
				aplicacoes_commit
				INNER JOIN gerador_tickets ON aplicacoes_commit.ticket = gerador_tickets.numero_ticket INNER JOIN gerador_tickets_pedidos ON gerador_tickets.num_pedido = gerador_tickets_pedidos.id $where GROUP BY
				gerador_tickets_pedidos.nome_cliente
				ORDER BY gerador_tickets_pedidos.nome_cliente desc
				";
				
				//echo $sql;
				//break;
				$result = mysql_query($sql);
				$y=1;
				while ($linha = mysql_fetch_assoc($result)) {
					$grupos .= "<br />".$linha["nome_cliente"];
				
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
					   		ORDER BY c.ordem";   
				
							//EXECUTA A QUERY               
							$sql2 = mysql_query($sql2);       
							$row = mysql_num_rows($sql2) or die("erro na busca dos nomes das competências");    
							
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
									$row = mysql_num_rows($sql3) or die("erro na busca das questões");    
									
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
					for($a=1;$a<=$nPessoas;$a++){
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
				
				$datay2 = array(6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,4,6,6,7);
			$datay3 = array(4,4,6,6,5,6,0,5,4,0,4,4,5,4,5,3,4,4,5,5);		
				
			$i = 0;
			while ($i<21){
					$res=0;
					$nota110 = $graCOMPETENCIA[$i];
					
					
					if(($nota110 >= $datay3[$i]) or ($nota110 <= $datay2[$i])){
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
  		Avalia o grau de identifica��o do indiv�duo com a atividade de planejar. Entende-se planejar com a��o de criar recursos para se atingir os objetivos, definindo <br /> as linhas de a��o, prazos e meios.
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


<!------    ORGANIZA�AO     ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    		<h1> 2 - Capacidade de Organiza��o</h4>
    		</td>
    	</tr>	
    	</table>
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
  		Avalia a capacidade do indiv�duo para acompanhar e promover o desenvolvimento de sua equipe, atrav�s de treinamentos, fornecimento de informa��es, dados <br /> e orienta��es.
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

<!------    LIDERAN�A    ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
    		<h1> 4 - Estilo de lideran�a</h4>
		    </td>
		 </tr>
		</table>
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
    	<table width="100%" align="center">
	    	<tr>
	    		<td align="left">
	    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
	    		</td>
	    		
	    		<td >
	    			<b>Data</b>:  <? echo date("d/m/Y")?>
	    		</td>
	    		<td >
	    			<b>N� Pessoas</b>: <?=$nPessoas?>
	    		</td>
	    	</tr>
	    	
	    	<tr>
	    		<td colspan="3" width="100%" align="center">
	<h1>5 - Estilo de comunica��o</h4>
				</td>
			</tr>
		</table>	
	
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>6 - Tomada de decis�o</h4>
</td>
</tr>
</table></td>
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>7 - Capacidade de delega��o</h4>
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
<!------ DETALHISMO/DELEGA��O ------>
<div class="folha">&nbsp;</div>
<!------ TEMPO DE EXECU��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>8 - Administra��o do tempo</h4>
</td>
</tr>
</table>


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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia o volume de trabalho que o indiv�duo est� suportando. Se necesita trabalhar em excesso, ou se est� se sentindo sub-aproveitado.</td>
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
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia o volume de trabalho que o indiv�duo est� suportando. Se necesita trabalhar em excesso, ou se est� se sentindo sub-aproveitado.</td>
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

<!------ PERCEP��O / PRIORIZA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia o grau de aten��o concentrada em um assunto ou tarefa. Sugere se o comportamento � dispersivo e n�o conclusivo e se o indiv�duo consegue trabalhar <br /> com imprevistos e emerg�ncias sem se prejudicar. Avalia tamb�m sua capacidade em perceber bem o conjunto e mudar suas prioridades, conforme a demanda.</td>
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
<!------ PERCEP��O / PRIORIZA��O ------>
<div class="folha">&nbsp;</div>
<!------ ADAPTABILIDADE A MUNDAN�AS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>12 - Gest�o de mudan�as</h4>
</td>
</tr>
</table>

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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia se o indiv�duo est� se apresentando submisso com a figura de chefia, ou se consegue estabelecer uma rela��o de confian�a, criando um clima <br /> de parceria e abertura.</td>
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
<!------ RELA��O COM AUTORIDADE ------>
<div class="folha">&nbsp;</div>

<!------ ADMINISTRA��O DE CONFLITOS ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>14 - Gest�o de conflitos</h4>
		</td>
		</tr>
		</table>
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>15 - Controle das emo��es</h4>
</td>
</tr>
</table></td>
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
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia o grau de envolvimento do indiv�duo com outras pessoas.</td>
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
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia o grau de necessidade do indiv�duo em se integrar, pertencer, dar e receber apoio de grupos. Sugere comportamento de colabora��o e individualismo <br /> e o n�vel de concess�o dispendida a outra pessoa.</td>
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
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
Avalia a forma como o indiv�duo � percebido pelo grupo e o seu grau de auto-estima.</td>
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
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>19 - T�nus vital</h4>
</td>
</tr>
</table></td>
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
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" width="100%" align="center">
<h1>20 - Necessidade de realiza��o</h4>
</td>
</tr>
</table>
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
<p>
<img src="graficos_grupos/realizacao.png" border="0">
</p>

</td>
</tr>
</table>
</p>
<!------ REALIZA��O ------>

<div class="folha">&nbsp;</div>
<!------ REALIZA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
<!------ REALIZA��O ------>

<div class="folha">&nbsp;</div>
<!------ REALIZA��O ------>
<p>
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
<tr>
<td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
<td align="center">
    	<table width="100%" align="center">
    	<tr>
    		<td align="left">
    			<b>Organiza��o/Grupo</b>: <?=$grupos?>
    		</td>
    		
    		<td >
    			<b>Data</b>:  <? echo date("d/m/Y")?>
    		</td>
    		<td >
    			<b>N� Pessoas</b>: <?=$nPessoas?>
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
					<td align="center"><span style="color:#0000ff; text-transform:uppercase; font-size:14px;" ><u><b>Sustenta��o</b></u></span></td>
					
				</tr>
				<?=$tabela_sustencao?>
			
			</table>
		</td>

		<td valign="top">
			<table style="border: 4px solid #ffff00;" width="70%">
				<tr>
					<td align="center"><span style="color:#ffff00; text-transform:uppercase; font-size:14px;" ><u><b>Aceit�vel</b></u></span></td>
					
				</tr>
				<?=$tabela_aceitavel?>
			
			</table>
		</td>
		
		<td valign="top">
			<table style="border: 4px solid #ff0000;" width="70%">
				<tr>
					<td align="center"><span style="color:#ff0000; text-transform:uppercase; font-size:14px;" ><u><b>Cr�tico</b></u></span></td>
				</tr>
				
				<?=$tabela_critico?>
			
			</table>	

		</td>
	</tr>
</table>
</div>
</p>
<!------ REALIZA��O ------>

</body>
</html>
		