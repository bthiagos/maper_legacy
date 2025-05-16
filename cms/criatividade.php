<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

//tres quatroseis setedez = 0;

$tres= $_REQUEST["tres"];
$quatroseis = $_REQUEST["quatroseis"];
$setedez = $_REQUEST["setedez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];


$tres = ($tres*100)/$nPessoas;
$quatroseis = ($quatroseis*100)/$nPessoas;
$setedez = ($setedez*100)/$nPessoas;
$media = ($media*100)/$nPessoas;

$tres = number_format($tres,1,".","");
$quatroseis = number_format($quatroseis,1,".","");
$setedez = number_format($setedez,1,".","");
$media = number_format($media,1,".","");


$soma = $media+$tres+$quatroseis+$setedez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($media,$tres,$quatroseis,$setedez);

// Create the Pie Graph. 
$graph = new PieGraph(900,700);
$graph->img->SetMargin(20,20,20,20); 

$graph->SetShadow();

// Setup title

// The pie plot
$p1 = new PiePlot($data);

// Move center of pie to the left to make better room
// for the legend
$p1->SetCenter(0.50,0.60);

// No border
$p1->ShowBorder(false);

// Label font and color setup
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("darkred");

// Use absolute values (type==1)
$p1->SetLabelType(PIE_VALUE_ABS);

// Label format
$p1->value->SetFormat("%1.1f%%");
$p1->value->Show();

// Size of pie in fraction of the width of the graph
$p1->SetSize(0.3);

// Legends
$lang = $_GET["lang"];

$item = array();
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Criatividade'");
while($d = mysql_fetch_array($desc)) {

	if($lang == "pt") {
		array_push($item,$d["descricao"]);
	}
	if($lang == "es") {
		array_push($item,$d["descricao_es"]);
	}
	if($lang == "en") {
		array_push($item,$d["descricao_en"]);
	}
}

$p1->SetLegends(array("$media%% ".$item[0],"$tres%% ".$item[1],"$quatroseis%% ".$item[2],"$setedez%% ".$item[3]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/criatividade.png");
?>