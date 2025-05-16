<?php
include ("src/jpgraph.php");
include ("src/jpgraph_line.php");
include ("conn.php");


$datay = array();

//CONECTA AO MYSQL                     
$sql = " SELECT * FROM aplicacoes WHERE id=".$_REQUEST["id"]; 
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
			

				if ($i >= 0 and $i <= 21) {
					
					$datay[$i] = $competencias[$y];
				}
				
			$total = $total + $competencias[$i];
			$i++;
			$linha_arquivo++;
			}
}
	}
	
	


// BARRA FIXA
$datay2 = array("",6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,4,6,6,7,"");
$datay3 = array("",4,4,6,6,5,6,0,5,4,0,4,4,5,4,5,3,4,4,5,5,"");



$graph = new Graph(950,500,"auto");
$graph->SetScale("textint",0,10);
$graph->yscale-> ticks->Set(2,2);

$datax=array("","Planejamento","Organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.à mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização","");

$graph->img->SetMargin(40,170,40,140);    
$graph->SetShadow();
$graph->SetMarginColor("#ffffff");
//$graph->SetBackgroundColor("#FEFEDF");
$graph->SetColor('#ffffff');

$graph->title->Set("Avaliação do Potencial e Perfil - $pNome");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->legend->Pos(0.0,0.1,"right","center");


$p1 = new LinePlot($datay);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("blue");
$p1->mark->SetWidth(4);
$p1->SetColor("blue");
$p1->SetWeight(2);
$p1->SetLegend("Perfil Candidato");


$p2 = new LinePlot($datay2);
$p2->SetFillColor("#FFFF66@0.0");
$p2->mark->SetWidth(0);
$p2->SetColor("#FFFF66");
$p2->SetLegend("Perfil Ideal");


$p3 = new LinePlot($datay3);
$p3->SetFillColor("#ffffff@0.0");
$p3->mark->SetWidth(0);
$p3->SetColor("#ffffff");


$graph->Add($p2);
$graph->Add($p3);
$graph->Add($p1);






$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(90);


$codigo_id = $codigo_id."grafico2_teste.png";
// Display the graph


$graph->Stroke("graficos/$codigo_id");
?>