<?

include ("conn.php");
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

$t = "aplicacoes".$tabela_commit;
//CONECTA AO MYSQL                     
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");
//$datax=array("Capacidade de planejamento","Capacidade de organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização");

$sustentacao = array();
$aceitavel = array();
$critico = array();

$codigo_id = $_REQUEST["id"];

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
	

			$i = 0;
			$linha_arquivo = 1;
		//	echo "<p><b>CompetÃªncias:</b></p>";
			while ($i<20){
				
				$nota110 = base10(($i+1),$competencias[$i]);
				
				//$nota = $competencias[$i];
				//$compsid = $i+1;
				//$pegarb10 = mysql_query("SELECT base10 FROM feedbacks WHERE competencia_id = '$compsid' AND nota = '$nota'");
				//$pegarb10 = mysql_fetch_array($pegarb10);
				
				//$nota110 = $pegarb10["base10"];
				
				
				if ($nota110 <= 3) {
					
					$tabela_critico .= "<tr><td style=\"font-size:9px;\">".
					$datax[$i]
					."</td></tr>";
				}
					

				if ($nota110 >= 4 and $nota110 <= 6) {
					
					$tabela_aceitavel .= "<tr><td style=\"font-size:9px;\">".
					$datax[$i]
					."</td></tr>";
				}
				
					
				if ($nota110 >= 7) {
					
					$tabela_sustencao .= "<tr><td style=\"font-size:9px;\">".
					$datax[$i]
					."</td></tr>";
				}	
				
				
				
				
			$total = $total + $competencias[$i];
			$i++;
			$linha_arquivo++;
			}
}
	}


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
	
?>
<div style="margin-left:40px;">



<table border="0" style="width: 600px;"> 
	<tr>
		<td valign="top" style="width: 170px;">
			<table style="border: 4px solid #0000ff; width: 150px">
				<tr>
					<td align="center"><span style="color:#0000ff; text-transform:uppercase; font-size:14px;" ><u><b>Sustentação</b></u></span></td>
					
				</tr>
				<?=$tabela_sustencao?>
			
			</table>
			<table style="width: 150px;">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Ideal</td>
					
				</tr>
			</table>
		</td>

		<td valign="top" style="width: 170px;">
			<table style="border: 4px solid #ffff00; width: 150px;">
				<tr>
					<td align="center"><span style="color:#ffff00; text-transform:uppercase; font-size:14px;" ><u><b>Aceitável</b></u></span></td>
					
				</tr>
				<?=$tabela_aceitavel?>
			
			</table>
			<table  style="width: 150px;">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Próximo do Ideal</td>
					
				</tr>
			</table>
		</td>
		
		<td valign="top" style="width: 170px;">
			<table style="border: 4px solid #ff0000; width: 150px;">
				<tr>
					<td align="center"><span style="color:#ff0000; text-transform:uppercase; font-size:14px;" ><u><b>Crítico</b></u></span></td>
				</tr>
				
				<?=$tabela_critico?>
			
			</table>
			<table style="width: 150px;">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Requer Atenção</td>
					
				</tr>
			</table>	

		</td>
	</tr>
</table>
</div>


