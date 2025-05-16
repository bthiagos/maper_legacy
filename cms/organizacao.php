<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

$zeroumdois = $_REQUEST["zeroumdois"];
$tres = $_REQUEST["tres"];
$sete = $_REQUEST["sete"];
$oitonovedez = $_REQUEST["oitonovedez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];


$zeroumdois = ($zeroumdois*100)/$nPessoas;
$tres = ($tres*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$sete = ($sete*100)/$nPessoas;
$oitonovedez = ($oitonovedez*100)/$nPessoas;

$zeroumdois = number_format($zeroumdois,1,".","");
$tres = number_format($tres,1,".","");
$media = number_format($media,1,".","");
$sete = number_format($sete,1,".","");
$oitonovedez = number_format($oitonovedez,1,".","");

$soma = $zeroumdois+$tres+$media+$sete+$oitonovedez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zeroumdois,$tres,$media,$sete,$oitonovedez);

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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Organização'");
while($d = mysql_fetch_array($desc)) { 
 
	if($lang == "pt" or $lang == "br") {
		array_push($item,$d["descricao"]);
	}
	if($lang == "es") {
		array_push($item,$d["descricao_es"]);
	}
	if($lang == "en") {
		array_push($item,$d["descricao_en"]);
	}
}


// Legends
$p1->SetLegends(array("$zeroumdois%% ".$item[0],"$tres%% ".$item[1],"$media%% ".$item[2],"$sete%% ".$item[3],"$oitonovedez%% ".$item[4]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/organizacao.png");
?>