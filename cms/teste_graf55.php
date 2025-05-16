<?php
include("library.php");
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}
$url3 = "http://www.appweb.com.br/cms/teste_graf2.php?id=".$_REQUEST["id"]."&commit=$commit";
executa_url("$url3");
$t = "aplicacoes".$tabela_commit;

include ("src/jpgraph.php");
include ("src/jpgraph_line.php");
include ("src/jpgraph_bar.php");
include ("conn.php");

$l2datay3 = array();
$l2datay1 = array();
$l2datay2 = array();
//CONECTA AO MYSQL                     
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

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

				
				if ($nota110 <= 3) {
					
					$l2datay3[$i] = $nota110;
					$l2datay1[$i] = 0;
					$l2datay2[$i] =0;
				}
					

				if ($nota110 >= 4 and $nota110 <= 6) {
					
					$l2datay2[$i] = $nota110;
					$l2datay1[$i] = 0;
					$l2datay3[$i] = 0;
				}
				
					
				if ($nota110 >= 7) {
					
					$l2datay1[$i] = $nota110;
					$l2datay2[$i] = 0;
					$l2datay3[$i] = 0;
				}	
				
			$total = $total + $competencias[$i];
			$i++;
			$linha_arquivo++;
			}
}
	}
			
$l1datay = array(7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7);



$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Cap. priorizar e trab. c/ imprevistos","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");

//$datax=array("Capacidade de planejamento","Capacidade de organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização");

// Create the graph. 
$graph = new Graph(900,700,"auto"); 
$graph->SetScale("textint",0,10);
//$graph->SetYScale("lin");


//$graph->img->SetMargin(180,310,180,280);  
$graph->img->SetMargin(20,140,20,240); 
$graph->SetMarginColor("#ffffff");
$graph->SetShadow();


// Create the linear error plot
$l1plot=new LinePlot($l1datay);
$l1plot->SetColor("red");
$l1plot->SetWeight(2);
$l1plot->SetLegend("Desempenho Ideal");
$graph->legend->Pos(0.0,0.1,"right","center");





// Create the bar plot

	$bplot1 = new BarPlot($l2datay1);
	$bplot1->SetFillColor("blue");
	$bplot1->SetLegend("Fator de Sustentação");
	
	$bplot2 = new BarPlot($l2datay2);
	$bplot2->SetFillColor("yellow");
	$bplot2->SetLegend("Fator Aceitável");

	$bplot3 = new BarPlot($l2datay3);
	$bplot3->SetFillColor("red");
	$bplot3->SetLegend("Fator Crítico");

	

// ...and add it to the graPH
//$graph->Add($gbplot);


// Add the plots to t'he graph

$graph->Add($bplot1);
$graph->Add($bplot2);
$graph->Add($bplot3);
$graph->Add($l1plot);


$graph->title->Set("Avaliação do Potencial e Perfil - $pNome" );
//$graph->xaxis->title->Set("X-title");
//$graph->yaxis->title->Set("Y-title");


// Label every 2:nd tick mark
$graph->xaxis->SetTextLabelInterval(1);

// Setup the labels
//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(90);


$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);


$codigo_id = $codigo_id."grafico.png";
// Display the graph
$graph->Stroke("graficos/$codigo_id");

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