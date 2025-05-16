<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');


$zerodois = $_REQUEST["zerodois"];
$tresquatro = $_REQUEST["tresquatro"];
$setedez = $_REQUEST["setedez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];

$zerodois = ($zerodois*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$tresquatro = ($tresquatro*100)/$nPessoas;
$setedez = ($setedez*100)/$nPessoas;

$zerodois = number_format($zerodois,1,".","");
$media = number_format($media,1,".","");
$tresquatro = number_format($tresquatro,1,".","");
$setedez = number_format($setedez,1,".","");

$soma = $zerodois+$tresquatro+$media+$setedez;
if($soma < 100){
	$media = 100-$soma+$media;
}

if($soma > 100){
	$media =  $media -($soma-100);
}

// Some data
$data = array($zerodois,$tresquatro,$media,$setedez);

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

$vendas = false;
if(isset($_GET["v"])) {
	$vendas = true;
}


$item = array();
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Administração de Conflitos'");
while($d = mysql_fetch_array($desc)) {

	if($lang == "pt") {
		if($vendas) {
			if($d["descricao_vendas"] != "") {
				array_push($item,$d["descricao_vendas"]);
			} else {
				array_push($item,$d["descricao"]);
			}
		} else {
			array_push($item,$d["descricao"]);
		}
	}
	if($lang == "es") {
		array_push($item,$d["descricao_es"]);
	}
	if($lang == "en") {
		array_push($item,$d["descricao_en"]);
	}
}

$p1->SetLegends(array("$zerodois%% ".$item[0],"$tresquatro%% ".$item[1],"$media%% ".$item[2],"$setedez%% ".$item[3]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/administracaodeconflitos.png");
?>


