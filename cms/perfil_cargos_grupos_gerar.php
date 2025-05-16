<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

		if($_REQUEST["commit"]){
			$commit=$_REQUEST["commit"];
			$tabela_commit = "_commit";
		}

$t = "aplicacoes".$tabela_commit;
				
		$i=0;
		while($i<20){
								$peso = "peso_".$i;
								$pesos .=	$_POST[$peso]."|";
								$i++;
		}							
		$pesos = trim($pesos);
		$descricao = nl2br($_POST["descricao"]);
        
       
        $cods = $_POST["cods"];        
        $cods_array = explode("/",$cods);
        
        $k=0;
        while($k <= sizeof($cods_array)) {                                        
		//echo $pesos;
		$ide = $cods_array[$k];
        $sql_updt = "UPDATE $t SET pesos = '$pesos' , descricao= '$descricao' WHERE id='$ide'"; 
		mysql_query($sql_updt);
        $k++;
        }        
		
		$cod = $_REQUEST["cod"];
        
     
		
        $html = "

<head>
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>

<style type='text/css'>
.style17 {font-family: Arial; font-size:5px; font-weight: bold; }
.style18 {font-family: Helvetica; font-size:7px; }
body,td,th {
	font-family: Arial, Helvetica, serif;
	font-size:7px;
	margin-left: 8px;
	margin-top: 0px;
	margin-right: 10px;
	margin-bottom: 0px;
}

</style>
</head>
<body>";


/*
$i=0;
while($i<20){
			$teste = explode("|",$pesos);		
			//echo $teste[$i]."<br>";
			$i++;
}		
$i=0;
while($i<20){
	echo $teste[$i];
	$i++;
}
*/

//$datax=array("Planejamento","Organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização");
$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Percepção/ priorização","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");

		$dia = date("j");
		$mes = date("n");
		$ano = date("Y");
/*	if($_REQUEST["gerar"]){
		$i=0;
		$pos=1;
		while($i<20){
			$peso = "peso_".$i;
			echo $pos.".&nbsp;&nbsp;".$datax[$i].".&nbsp;&nbsp;".$_POST[$peso]."<BR>";
			
		$i++;$pos++;	
		}
	}
		echo "<BR><BR>";*/
?>

<?
$codigo_id = $cods;

//CONECTA AO MYSQL                     

	if($_REQUEST["c"]){
			$commit=$_REQUEST["c"];
			$tabela_commit = "_commit";
		}

$t = "aplicacoes".$tabela_commit;
$where_cod = str_replace("/","' OR ".$t.".id = '",$codigo_id);
$where_cod = "(".$t.".id = '".$where_cod."')";

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
 
$sql = " SELECT * FROM $t WHERE $where_cod"; 
$result = mysql_query($sql);

$up = 0;
while($linha = mysql_fetch_assoc($result)) {

$html .= "<div style='height: 100%'>";
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
$pDescricao= $linha["descricao"];  
$pPesos= $linha["pesos"];  
$pSenha= "Spider29";  
$pesos2 = array();
$i=0;
while($i<20){
			$pesos = explode("|",$pPesos);		
			//echo $teste[$i]."<br>";
			$i++;
}
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
	}
	$i = 0;
	$pos=1;
		$peso_total = 0;
		$nota_total = 0;
		$total_total = 0;
	
    $html .='
	
	<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:19px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong>'.$pNome.'<br />
            <strong>CPF: </strong>'.$cpf.'</td>
          <td width="52%">  <strong>Nasc: </strong>'.$pNasc.'<br />
            <strong>Cargo: </strong>'.$pCargo.'</td>
        </tr>
      </table>
    </td>
  </tr>
</table>


	<table align="center" width="90%" border="0" style="margin-top:5px;">
	<tr>
		<td align="center" colspan="2" class="style18" style="font-size:15px; margin-bottom:5px;">
	<b>FORMULÁRIO DE AVALIAÇÃO DO PERFIL DO CARGO</b>
		</td>
	</tr>
	
	
	<tr>
		<td colspan="2">'.$pDescricao.'
		</td>
	</tr>
	
	
		<tr><td width="50%">
	<table border="0"width="100%" align="left">
						<tr>
							<td width="50%"><span class="style18">CARACTERÍSTICAS <br>PROFISSIONAIS</span></td>
							<td ><span class="style18">Peso</span></td>
							<td ><span class="style18">Nota</span></td>
							<td ><span class="style18">Total</span></td>
							
						</tr>';
	
	
	while ($i<10){ 
		$peso = "peso_".$i;
		
		$html .= '
		<tr>
			<td><span class="style18">'.$pos.'&nbsp;&nbsp;'.$datax[$i].'</span></td>
			<td><span class="style18">'.$pesos[$i].'</span></td>
			<td><span class="style18">'.base10(($i+1),$competencias[$i]).'</span></td>
			<td><span class="style18">';
			
				$nota = base10(($i+1),$competencias[$i]);
				$valor_peso = $pesos[$i];
				$total = $nota * $valor_peso;
			
				
		$html .= $total.'
			</span>
			</td>
		
		</tr>
	';
		
		
		$peso_total += $pesos[$i];
		$nota_total += $nota;
		$total_total += $total;


		$i++;
		$pos++;
	}
	
    $html .= '
		<tr>
			<td><span class="style18">TOTAIS</span></td>
			<td><span class="style18">'.$peso_total.'</span></td>
			<td><span class="style18">';
				$nota_total = $total_total/$peso_total;
				//echo number_format($nota_total,2);
				$nota_total = number_format($nota_total,2);
				$html .= $nota_total;
			
			$html .= '</span></td>
			<td><span class="style18">'.$total_total.'</span></td>
		</tr>
		
		
	
	</table>
		</td>
	<td>

	<table border="0" width="100%" align="left">
						<tr>
							<td width="50%"><span class="style18">CARACTERÍSTICAS<br> PESSOAIS</span></td>
							<td ><span class="style18">Peso</span></td>
							<td ><span class="style18">Nota</span></td>
							<td ><span class="style18">Total</span></td>
							
						</tr>
						';
                        
						$peso_total = 0;
						$nota_total2 = 0;
						$total_total2 = 0;
						$i=10;
						   $pos = 1;
						while($i<20) {
							$peso = "peso_".$i;
							
                            $html .= '
						<tr>
							<td><span class="style18">';
							$html .= $pos.".&nbsp;&nbsp;".$datax[$i]."</span></td>";
                            $html .= '
							<td><span class="style18">'.$pesos[$i].'</span></td>
							<td><span class="style18">'.base10(($i+1),$competencias[$i]).'</span></td>
							<td><span class="style18">';
								
									$nota = base10(($i+1),$competencias[$i]);
									$valor_peso = $pesos[$i];
									$total = $nota * $valor_peso;
									$html .= $total;
							$html .= '
								</span>
							</td>
						
						</tr>';
						
					
						
						 $peso_total += $pesos[$i];
								$nota_total2 += $nota;
								$total_total2 += $total;
						
						
						$i++;$pos++; 
                        }
						
								$html .='			
								<tr>
									<td><span class="style18">TOTAIS</span></td>
									<td><span class="style18">'.$peso_total.'</span></td>
									<td><span class="style18">';
									$nota_total2 = $total_total2/$peso_total;
								//	echo number_format($nota_total2,2);
									$nota_total2 = number_format($nota_total2,2);
									$html .= $nota_total2;
									$html .= '</span></td>
									<td><span class="style18">'.$total_total2.'</span></td>
								</tr>
							
							</table>
							
							</td>
							</tr>			
					
						
						</table>
						<table border="0" align="center" width="79%"> 
							<tr align="left">
									<td width="50%" valign="top">
									<span class="style18">	M.P. GERAL =  '.number_format((($nota_total2+$nota_total)/2),2).'</span>
									</td>	
									<td>
										<table border="0" width="100%">
											<tr>
												<td > <span class="style18">PESOS</span></td>
												<td > <span class="style18">NOTAS</span></td>
												<td colspan="2" > <span class="style18">DATA:  '.$dia.'/'.$mes.'/'.$ano.'</span></td>
									
											</tr>
											
											<tr>
												<td><span class="style18" style="font-size:6px;">   3 – INDISPENSÁVEL</span></td>
												<td> <span class="style18"style="font-size:6px;"> 9-10 – MUITO BOM </span></td>
												<td colspan="2"><span class="style18"style="font-size:6px;"> &nbsp;</span></td>
									
											</tr>	
											
											<tr>
												<td><span class="style18"style="font-size:6px;">  2 - MUITA IMPORTÂNCIA</span></td>
												<td><span class="style18"style="font-size:6px;">  7-8 - BOM</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
									
											</tr>
											
											<tr>
												<td>  <span class="style18"style="font-size:6px;">  1 – DESEJÁVEL</span></td>
												<td> <span class="style18"style="font-size:6px;">  5-6 – MÉDIO</span></td>
												<td> </td>
												<td> </td>
									
											</tr>
											
											<tr>
												<td>   </td>
												<td>  <span class="style18"style="font-size:6px;"> 3-4 – FRACO</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
									
											</tr>
											
											<tr>
												<td>   </td>
												<td>  <span class="style18"style="font-size:6px;">  0-2 - INSUFICIENTE</span></td>
												<td> </td>
												<td> </td>
									
											</tr>
											
										</table>
									</td>
							</tr>
						</table>
      ';

}} //fim do while
					$html .='
					<div style="heigth:15px;">&nbsp;&nbsp;</div>
					<table width="79%" border="0" align="center">
						<tr>
							<td valign="top"><hr style="height: 1px; width: 70%; color: #666666; margin-top:10px">
						<div style="text-align: center; font-size: 12px">        
						Maria Lúcia Rodrigues Corrêa CRP 1560	
						</div>
						</td>
						</tr>
					</table>
                  </div>';
  }
  
  $html .='
</body>
</html>';


        
	
		require_once("dompdf/dompdf_config.inc.php");
		
		//echo $html;
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'portrait');
		$dompdf->render();
        $dompdf->stream("App_Web.pdf",array("Attachment" => 0));

mysql_close();
?>
