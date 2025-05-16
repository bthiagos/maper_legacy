<?php
$item = $_REQUEST["item"];
$pergunta2 = trim($_REQUEST["pergunta"]);
$alternativas = $_REQUEST["alternativa"];
$respostas = $_REQUEST["resposta"];
$nome_pasta = $_REQUEST["pasta"];

$pergunta2  = str_ireplace(" ","",$pergunta2);


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
		if($todas_alternativas[$y] == "Informações Adicionais"){
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

for ($y=0;$y<(count($todas_respostas));$y++) {
    if($todas_respostas[$y] != 0)
    {  
		$legendas[$y]   = ''.$todas_alternativas[$y].'';		
		$data[$y] = $todas_respostas[$y];		
    }
}


$nome_imagem = $item."_".$pergunta2;

include ("src/jpgraph.php");
include ("src/jpgraph_bar.php");

// Some data

// New graph with a drop shadow
$graph = new Graph(700,400,'auto');
$graph->SetShadow();

// Use a "text" X-scale
$graph->SetScale("textlin");

// Specify X-labels
$graph->xaxis->SetTickLabels($legendas);

// Set title and subtitle
//$graph->title->Set($;);

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Create the bar plot
$b1 = new BarPlot($data);
$b1->value->SetFormat("%d");
$b1->value->Show();
$graph->img->SetMargin(40,170,20,190);
$graph->xaxis->SetTickLabels($legendas);
$graph->xaxis->SetLabelAngle(90);
//$b1->SetAbsWidth(6);
//$b1->SetShadow();

// The order the plots are added determines who's ontop
$graph->Add($b1);

// Finally output the  image
$graph->Stroke("graficos_pesquisa/barra/$nome_pasta/$nome_imagem.png");

?>


