<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');


$zerodois = $_REQUEST["zerodois"];
$sete = $_REQUEST["sete"];
$tres = $_REQUEST["tres"]; 
$oitodez = $_REQUEST["oitodez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];


$zerodois = ($zerodois*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$sete = ($sete*100)/$nPessoas;
$oitodez = ($oitodez*100)/$nPessoas;
$tres = ($tres*100)/$nPessoas;

$zerodois = number_format($zerodois,1,".","");
$media = number_format($media,1,".","");
$sete = number_format($sete,1,".","");
$oitodez = number_format($oitodez,1,".","");
$tres = number_format($tres,1,".","");


$soma = $zerodois+$tres+$media+$sete+$oitodez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zerodois,$tres,$media,$sete,$oitodez);

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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Controle Emocional'");
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

$p1->SetLegends(array("$zerodois%% ".$item[0],"$tres%% ".$item[1],"$media%% ".$item[2],"$sete%% ".$item[3],"$oitodez%% ".$item[4]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/controleemocional.png");
?>


