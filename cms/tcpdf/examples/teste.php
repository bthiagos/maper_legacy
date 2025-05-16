<?php


function ideal ($pCompentencia){

	$valor[11];
	
	for ($i=0;$i<11;$i++){
		$valor[$i]=999;
	} //fecha for

			$sql = " 
       		SELECT i.valor 
       		FROM  ideais i, competencias c
			WHERE c.competencias_id = i.competencia_id and c.ordem = " . $pCompentencia . "
	   		ORDER BY i.valor";  

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos valores ideais das competÃªncias");    
			
			for ($z=0;$z<$row;$z++){
				 $pos =  mysql_result($sql, $z, "valor");
				 $valor[$pos] = $pos;
			} //fecha for
			
		echo "<br>";
	//echo "<div style=\"border: 1px solid #000000; letter-spacing: 70px;\">";
	for ($i=0;$i<11;$i++){
		if ($valor[$i]==999) {
			$valor[$i] = $i;
			echo $valor[$i] ." ";
		} else {echo " &nbsp;<b><u>".$valor[$i]."</u></b> &nbsp;"; }
		
	}
	//echo "</div>";
	echo "<br>";

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

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('APP_WEB');
$pdf->SetTitle('APP_WEB');
$pdf->SetSubject('APP_WEB');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();


$pdf->writeHTML('

	<table width="511px" border="1" cellspacing="0" cellpadding="2"  align="left">
		  <tr>
		    <td width="30px">&nbsp;</td>
		    <td width="150px">Criterio</td>
		    <td width="31px">Nota</td>
		    <td width="300px">Avaliacao</td>
		  </tr>
	</table>   '


, true, 0, true, 0);



$pdf->writeHTML("

	<table width=\"511px\" border=\"1\" cellspacing=\"0\" cellpadding=\"2\"  align=\"left\" style=\"margin-top: 0px\">
		  <tr>
		    <td width=\"30px\">1</td>
		    <td width=\"150px\">Planejamento <br /><br /> 0 1 2 3 4 5 6 7 8 9 10</td>
		    <td width=\"31px\" align=\"center\" style=\"vertical-align: middle;\"><br/><br/><span style=\"margin-top:15px;\">7</span></td>
		    <td width=\"300px\">Pessoa que apresenta algum equilíbrio entre planejamento e execução, com maior tendência à teorização. Interessa-se mais pelo planejamento do que pela execução. Tal atitude pode gerar certa frustração se não atingir suas metas por se deter em excesso na etapa do planejamento. Se tiver dificuldades com a capacidade organizativa, pode ser um mecanismo de compensação para suprir esta deficiência.</td>
		  </tr>
	</table>   "


, true, 0, true, 0);



$codigo_id = $_REQUEST["id"]; 
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
$pNasc = $linha["nasc"];  
$pPerfil = "Profissional"; 
$pCargo= $linha["cargo"];  
$pSenha= "Spider29";  


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

<? $tabela .= "

<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\"  align=\"center\">
  <tr>
    <td width=\"4%\">&nbsp;</td>
    <td width=\"12%\" nowrap><span class=\"style17\">Critério</span></td>
    <td width=\"5%\" align=\"center\"><span class=\"style17\">Nota</span></td>
    <td width=\"40%\" align=\"left\"><span class=\"style17\"> Avaliação</span></td>
  </tr>";

 
	$i = 0;
	$linha_arquivo = 1;
//	echo "<p><b>CompetÃªncias:</b></p>";
	while ($i<20){ 
		
	$tabela .="
		<tr><td width=\"4%\" valign=\"top\">";		
		$a = ($i+1);
		$tabela .="$a
		</td><td width=\"12%\" style=\"font-size:9px;\">";
		$b = $nome_competencias[$i] . "<br>"; 
		$c = ideal ($i+1);
		$tabela .= " $b $c
		</td><td  width=\"5%\" valign=\"middle\" align=\"center\">";
		$d = $competencias[$i]; 
		$tabela ." $d		</td><td align=\"left\" style=\"font-size:9px; font-align:center;\"><div style=\"width: 90%\">";
		 $texto = feedback(($i+1),$competencias[$i]); 
		 
		 $tabela .="
		<p>	
					     
			 $texto;
			
		</p>
		</div></td></tr>";
		
		if ($linha_arquivo == 8) {
		
		$tabela .= "</table>
		



<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\"  align=\"center\">
  <tr>
    <td width=\"4%\">&nbsp;</td>
    <td width=\"12%\" nowrap><span class=\"style17\">Critério</span></td>
    <td width=\"5%\" align=\"center\"><span class=\"style17\">Nota</span></td>
    <td width=\"40%\" align=\"left\"><span class=\"style17\"> Avaliação</span></td>
  </tr>  </table>";  


			$linha_arquivo = 0;
		}
		
		
		$total = $total + $competencias[$i];
		$i++;
		$linha_arquivo++;
	}
//	echo "Total = " . $total;
//	echo "<p><b>ConcluÃ­do</b></p>";
}//fim do if
}//fim do if

$pdf->writeHTML($tabela, true, 0, true, 0);



// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('teste.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
