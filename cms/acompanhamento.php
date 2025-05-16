<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

//$zeroumdoistres = $quatro = $cinco = $oito = $novedez = $media = 0;
$zeroumdoistres = $_REQUEST["zeroumdoistres"];
$quatro  = $_REQUEST["quatro"];
$cinco = $_REQUEST["cinco"];
$oito = $_REQUEST["oito"]; 
$novedez = $_REQUEST["novedez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];


$zeroumdoistres = ($zeroumdoistres*100)/$nPessoas;
$quatro = ($quatro*100)/$nPessoas;
$cinco = ($cinco*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$oito = ($oito*100)/$nPessoas;
$novedez = ($novedez*100)/$nPessoas;

$zeroumdoistres = number_format($zeroumdoistres,1,".","");
$quatro = number_format($quatro,1,".","");
$cinco = number_format($cinco,1,".","");
$media = number_format($media,1,".","");
$oito = number_format($oito,1,".","");
$novedez = number_format($novedez,1,".","");

$soma = $zeroumdoistres+$quatro+$cinco+$media+$oito+$novedez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zeroumdoistres,$quatro,$cinco,$media,$oito,$novedez);

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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Acompanhamento'");
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

$p1->SetLegends(array("$zeroumdoistres%% ".$item[0],"$quatro%% ".$item[1],"$cinco%% ".$item[2],"$media%% ".$item[3],"$oito%% ".$item[4],"$novedez%% ".$item[5]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/acompanhamento.png");
?>


