<?php
include ("src/jpgraph.php");
include ("src/jpgraph_line.php");
include ("conn.php");

if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

$org = $_GET["org"];

$lang = @$_GET["lang"];
if($lang != "br" and $lang != "en" and $lang != "es") { $lang = "br"; }

$t = "aplicacoes".$tabela_commit;
$datay = array();

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
	$datay[0] = "";
				$y = -1;
				$i = 1;
			$linha_arquivo = 1;
		//	echo "<p><b>CompetÃªncias:</b></p>";
			while ($i<22){
				
				$y++;
			
				if($org == 324 || $org == 487) { $imax = 20; } else { $imax = 21; }
				if ($i >= 0 and $i <= 21) {
					$liberado = true;
					$i_atual = $i;
    				if($org == 324 || $org == 487) { if($i == 10) { $liberado = false; } if($i > 10) { $i_atual = $i - 1; } }

    				if($liberado) {
						$datay[$i_atual] = $competencias[$y];
					}
				}
				
			$total = $total + $competencias[$i];
			$i++;
			$linha_arquivo++;
			}
}
	}
	
	


// BARRA FIXA
$datay2 = array("",6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,6,4,6,7,"");
$datay3 = array("",4,4,6,6,5,6,0,5,4,0,4,5,4,5,4,3,4,4,5,5,"");	


if($org == 324 || $org == 487) { 
	$datay2 = array("",6,6,7,7,6,7,1,7,6,5,6,6,6,6,4,6,4,6,7,"");
	$datay3 = array("",4,4,6,6,5,6,0,5,4,4,5,4,5,4,3,4,4,5,5,"");	

}


$graph = new Graph(900,700,"auto");
$graph->SetScale("textint",0,10);
$graph->yscale-> ticks->Set(2,4);

//$datax=array("","01- Capacidade de planejamento","02- Capacidade de organização","03- Capacidade de acompanhamento","04- Estilo de liderança","05-  Estilo de comunicação","06- Tomada de decisão","07- Capacidade de delegação","08- Administração do tempo","09- Volume de trabalho","10- Potencial criativo e flexibilidade","11- Cap. priorizar e trab. c/ imprevistos","12- Gestão de mudanças","13- Relacionamento com superiores","14- Gestão de conflitos","15- Controle das emoções","16- Relacionamento afetivo","17- Relacionamento em grupos","18- Imagem pessoal","19- Tônus vital","20- Necessidade de realização","");
$comp_sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC");
$datax = array("");
$c = 1;
$complang = "";
if($lang == "en" or $lang == "es") { $complang = "_".$lang; }
while($comp = mysql_fetch_array($comp_sql)) {
    if($c < 10) { $n = "0".$c; } else { $n = $c; }

    $liberado = true;
    if($org == 324 || $org == 487) { 
    	if($c == 10) { $liberado = false; } 
    	if($c > 10) {
    		$n = $n -1;
    	}
    }

    if($liberado) {
    	array_push($datax,$n."-".$comp["descricao".$complang]);
   	}
    $c++;
}
array_push($datax,"");


//$datax=array("","Capacidade de planejamento","Capacidade de organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização","");


//$graph->img->SetMargin(190,320,190,290);          
$graph->img->SetMargin(20,140,20,345); 
$graph->SetShadow();
$graph->SetMarginColor("#ffffff");
//$graph->SetBackgroundColor("#FEFEDF");
$graph->SetColor('#ffffff');

$titulo = "Mapeamento de perfil";
if($lang == "en") { $titulo = "Potential and Profile Evaluation"; }
if($lang == "es") { $titulo = "Evaluación de Potencial y Perfil"; }

$graph->title->Set("$titulo - $pNome");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->legend->Pos(0.0,0.1,"right","center");


$p1 = new LinePlot($datay);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("#4eba98@0.2");
$p1->mark->SetWidth(4);
$p1->SetColor("#4eba98@0.2");
$p1->SetWeight(2);
$titulo = "Perfil Candidato";
if($lang == "en") { $titulo = "Candidate Profile"; }
if($lang == "es") { $titulo = "Perfil del Candidato"; }
$p1->SetLegend($titulo);


$p2 = new LinePlot($datay2);
$p2->SetFillColor("#3c2885@0.8");
$p2->mark->SetWidth(0);
$p2->SetColor("#3c2885");

$titulo = "Perfil Ideal";
if($lang == "en") { $titulo = "Ideal Profile"; }
if($lang == "es") { $titulo = "Perfil Ideal"; }
$p2->SetLegend($titulo);


$p3 = new LinePlot($datay3);
$p3->SetFillColor("#ffffff@0.0");
$p3->mark->SetWidth(0);
$p3->SetColor("#ffffff");


$graph->Add($p2);
$graph->Add($p3);
$graph->Add($p1);






$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(90);


$codigo_id = $codigo_id."grafico2.png";
// Display the graph


$graph->Stroke("graficos/$codigo_id");
?>