<?

include ("conn.php");
$codigo_id = $_REQUEST["id"]; 
$orga = $_REQUEST["orga"]; 
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

$t = "aplicacoes".$tabela_commit;
//CONECTA AO MYSQL                     
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
//alert($_REQUEST["id"]);
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

//$datax=array("Planejamento","Organiza��o","Acompanhamento","Lideran�a","Comunica��o","Decis�o","Detalhismo","T. de Execu��o","Intens.Operacional","Flex./Criatividade","Percep��o","Adap.as mudan�as","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realiza��o");

$datax=array("Capacidade de planejamento","-Capacidade de organiza��o","Capacidade de acompanhamento","Estilo de lideran�a","Estilo de comunica��o","Tomada de decis�o","Capacidade de delega��o","Administra��o do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gest�o de mudan�as","Relacionamento com superiores","Gest�o de conflitos","Controle das emo��es","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","T�nus vital","Necessidade de realiza��o");

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
	

			$i = 0;
			$linha_arquivo = 1;
		//	echo "<p><b>Competências:</b></p>";
			while ($i<20){
				
				$nota110 = base10(($i+1),$competencias[$i]);
				
				if ($nota110 <= 4) {
					
					$tabela_critico .= "<tr><td style=\"font-size:9px;\">".
					$datax[$i]
					."</td></tr>";
				}
					

				if ($nota110 >= 5 and $nota110 <= 6) {
					
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
	
?>
<div style="margin-left:40px;">

<table border="0" width="100%">
	<tr>
		<td valign="top" width="33%">
			<table style="border: 4px solid #0000ff;" width="90%">
				<tr>
					<td align="center"><span style="color:#0000ff; text-transform:uppercase; font-size:14px;" ><u><b>Sustenta��o</b></u></span></td>
				</tr>
				<?=$tabela_sustencao?>

			
			</table>
			<table width="90%">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Ideal</td>
					
				</tr>
			</table>
			
		</td>

		<td valign="top" width="33%">
			<table style="border: 4px solid #ffff00;" width="90%">
				<tr>
					<td align="center"><span style="color:#ffff00; text-transform:uppercase; font-size:14px;" ><u><b>Aceit�vel</b></u></span></td>
					
				</tr>
				<?=$tabela_aceitavel?>
			</table>
			<table width="90%">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Pr�ximo do Ideal</td>
					
				</tr>
			</table>
			
		</td>
		
		<td valign="top" width="33%"> 
			<table style="border: 4px solid #ff0000;" width="90%">
				<tr>
					<td align="center"><span style="color:#ff0000; text-transform:uppercase; font-size:14px;" ><u><b>Cr�tico</b></u></span></td>
				</tr>
				
				<?=$tabela_critico?>
			
			</table>	
			<table width="90%">
				<tr>
					<td align="center" style="font-family: Arial; font-size: 14px; text-transform: uppercase; color: #3c3c3c; font-weight: bold;">Requer Aten��o</td>
					
				</tr>
			</table>

		</td>
	</tr>

</table>
</div>

<?



?>