<?php include("library.php"); ?><?php include("conn.php");
 ?><?
$lang = $_GET["lang"];

$where = $_POST["wherea"];

if($lang == "pt" or $lang == "br") {
	$desc = "descricao";
	$breve = "breve";
}
if($lang == "en") {
	$desc = "descricao_en";
	$breve = "breve_en";
}
if($lang == "es") {
	$desc = "descricao_es";
	$breve = "breve_es";
}

$datax = array();
$descx = array();
$sql_comps = mysql_query("SELECT $desc,$breve FROM competencias order by ordem ASC");
while($c = mysql_fetch_array($sql_comps)) {
	array_push($datax,$c[$desc]);
	array_push($descx,$c[$breve]);
}


//$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");



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

                $qtd_grupos = 0;

				while ($linha = mysql_fetch_assoc($result)) {

					$grupos .= "<br />".$linha["orga"]."<br />".$linha["grupo"];

				    $qtd_grupos++;

				}	

                if($qtd_grupos > 1) {

                    $grupos = "<br />".$qtd_grupos." grupos";

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

				       		SELECT c.".$desc."

				       		FROM  competencias c

					   		ORDER BY c.ordem ASC";   

				

							//EXECUTA A QUERY               

							$sql2 = mysql_query($sql2);       

							$row = mysql_num_rows($sql2) or die("erro na busca dos nomes das competÃªncias");    

							

							for ($i=0; $i<$row; $i++){

				   				$nome_competencias[$i] = htmlentities (mysql_result($sql2, $i, $desc));

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


			// Competencias 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20
			//$datay2 = array(6,6,7,7,6,7,6,7,6,2 ,5, 6, 6, 6, 6, 4, 6, 4, 6, 7);
			$datay2 = array(6,5,7,7,6,7,1,7,6,2, 5, 6, 5, 6, 5, 4, 6, 4, 6, 7);

			//$datay3 = array(4,4,6,6,5,6,4,5,4,0, 4, 5, 4, 5, 4, 3, 4, 4, 5, 5);	#antigo
			$datay3 = array(4,4,6,6,5,6,0,5,5,0, 4, 5, 4, 5, 4, 3, 5, 4, 5, 6);		

				

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



/*
			while ($i<=20) {

					$res=0;

					$nota110 = $graCOMPETENCIA[$i];


					
					if (($nota110 >= 0) and ($nota110 <= 4)) {
							$tabela_critico .= "<tr><td style=\"font-size:9px;\">".$datax[$i]."</td></tr>";
					} elseif  (($nota110 >= 5) and ($nota110 <= 6)) {
							$tabela_aceitavel .= "<tr><td style=\"font-size:9px;\">".$datax[$i]."</td></tr>";
					} elseif  ($nota110 >= 7) {
							$tabela_sustencao .= "<tr><td style=\"font-size:9px;\">".$datax[$i]."</td></tr>";
					}
	

				$i++;

			}

*/

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

    			<h1> 1	- <?=$datax[0]?></h1>

    		</td>

    	</tr>	

    	</table>

    </td>

  </tr>

 </table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

 

  <tr>

  	<td colspan="2">  		
  	<?=$descx[0]?>
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

    		<h1> 2 - <?=$datax[1]?></h1>

    		</td>

    	</tr>	

    	</table>

    </td>

  </tr>

 </table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

 

  <tr>

  	<td colspan="2">
  		<?=$descx[1]?>
  		
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

    		<h1> 3 - <?=$datax[2]?></h1>

	    	</td>

	 	 </tr>

	 </table> 

 	</td>

  </tr>

 </table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

 

  <tr>

  	<td colspan="2">

  		<?=$descx[2]?>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

    		<h1> 4 - <?=$datax[3]?></h1>

		    </td>

		 </tr>

		</table>

  </td>

  </tr>

 </table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

 

  <tr> 

  	<td colspan="2">


  	<?=$descx[3]?>
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

	<h1>5 - <?=$datax[4]?></h1>

				</td>

			</tr>

		</table>	

	

	</td>

	</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">


<?=$descx[4]?>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>6 - <?=$datax[5]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">

<?=$descx[5]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>7 - <?=$datax[6]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[6]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>8 - <?=$datax[7]?></h1>

</td>

</tr>

</table>





</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">


<?=$descx[7]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>9 - <?=$datax[8]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">

<?=$descx[8]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>10 - <?=$datax[9]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">

<?=$descx[9];?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>11 - <?=$datax[10]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[10]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>12 - <?=$datax[11]?></h1>

</td>

</tr>

</table>



</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">

 

<tr>
 
<td colspan="2">

<?=$descx[11]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>13 - <?=$datax[12]?></h1>

</td>

</tr>

</table>



</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[12]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>14 - <?=$datax[13]?></h1>

		</td>

		</tr>

		</table>

</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">

<?=$descx[13]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>15 - <?=$datax[14]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">

<?=$descx[14]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>16 - <?=$datax[15]?></h1>

</td>

</tr>

</table>

</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[15]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>17 - <?=$datax[16]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[16]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>18 - <?=$datax[17]?></h1>

</td>

</tr>

</table>

</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[17]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>19 - <?=$datax[18]?></h1>

</td>

</tr>

</table></td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[18]?>
</td>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

    		</td>

    	</tr>

    	<tr>

    		<td colspan="3" width="100%" align="center">

<h1>20 - <?=$datax[19]?></h1>

</td>

</tr>

</table>

</td>

</tr>

</table>





<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center">



<tr>

<td colspan="2">
<?=$descx[19]?>
</td>
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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

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

    			<b><? if($lang=="pt" or $lang =="br") { ?>Organização/Grupo <? } ?><? if($lang=="en") { ?>Organization/Group <? } ?><? if($lang=="es") { ?>Organización/Grupo <? } ?></b>: <?=$grupos?>

    		</td>

    		

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Data <? } ?><? if($lang=="en") { ?>Date <? } ?><? if($lang=="es") { ?>Data <? } ?></b>:  <? echo date("d/m/Y")?>

    		</td>

    		<td >

    			<b><? if($lang=="pt" or $lang =="br") { ?>Nº Pessoas <? } ?><? if($lang=="en") { ?>Nº Persons <? } ?><? if($lang=="es") { ?>Nº Personas <? } ?></b>: <?=$nPessoas?>

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

		