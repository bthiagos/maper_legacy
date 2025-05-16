<?php
$item = $_REQUEST["item"];
$pergunta2 = trim($_REQUEST["pergunta"]);
$alternativas = $_REQUEST["alternativa"];
$respostas = $_REQUEST["resposta"];
$nome_pasta = $_REQUEST["pasta"];

$pergunta2  = str_ireplace(" ","",$pergunta2);
//$alternativas = "Masculino|Feminino|";
//$respostas = "3|5|0|";


include ("src/jpgraph.php");
include ("src/jpgraph_pie.php");

$todas_respostas = explode("|",$respostas);
$todas_alternativas = explode("|",$alternativas);
$todas_alternativas = str_ireplace("-"," ",$todas_alternativas);

for ($y=0;$y<(count($todas_alternativas));$y++) {
	
	if($todas_alternativas[$y] == ""){
			unset ($todas_alternativas[$y]);
		}	
}

for ($y=0;$y<(count($todas_respostas));$y++) {
	

	if($y == (count($todas_alternativas))){
		if($todas_alternativas[$y] == "Informações Adicionais" or $todas_alternativas[$y] == "Informações adicionais"){
			unset ($todas_respostas[$y]);
		}
	}
	
		if($todas_alternativas[$y] == ""){
			unset ($todas_respostas[$y]);				
		}		
}
$n = count($todas_respostas);

if((count($todas_alternativas)) != (count($todas_respostas))){
	$n-1;
	unset ($todas_respostas[$n]);
}
//$nomes = array("silas","vinicius","carlos","tolo","daniel");

/// salvando todas as respostas pra a legenda e grafico
for ($y=0;$y<(count($todas_respostas)-2);$y++) {
		if($todas_respostas[$y] != 0)
        {        
			$legendas[$y]   = ''.$todas_alternativas[$y].' (%d)';		
			$data[$y] = $todas_respostas[$y];
        }            
}

// Some data
//$data = array(3,5);
$nome_imagem = $item."_".$pergunta2;
//echo "graficos_pesquisa/$nome_pasta/$nome_imagem.png";



$graph = new PieGraph(1320,720);
//$graph->SetMarginColor('gray');
$graph->SetShadow();
//$graph->SetShadow();

$graph->SetBox(true);

// Setup margin and titles
//$graph->title->Set("Exemplo: Horas de Trabalho");

$p1 = new PiePlot($data);
$p1->SetCenter(0.35,0.5);

// Setup slice labels and move them into the plot
$p1->SetCenter(0.35,0.5);

// No border
$p1->ShowBorder(false);

// Label font and color setup
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("darkred");
// Use absolute values (type==1)

if($_REQUEST["tiporesp"] == "1"){
$p1->value->SetFormat("%d");
$p1->SetLabelType(PIE_VALUE_ABS);
}
// Label format

$p1->value->Show();

// Size of pie in fraction of the width of the graph
$p1->SetSize(0.3);
$vinicius = "silas , rafael";
$p1->SetLegends($legendas);
$graph->legend->Pos(0.02,0.10);
$graph->Add($p1);

$graph->Stroke("graficos_pesquisa/$nome_pasta/$nome_imagem.png");
$graph->Stroke();

?>


