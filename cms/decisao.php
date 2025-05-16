<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

//$zeroum = $doisquatro = $cinco = $oitodez = $media = 0;

$zeroum = $_REQUEST["zeroum"];
$doisquatro = $_REQUEST["doisquatro"];
$cinco = $_REQUEST["cinco"]; 
$oitodez = $_REQUEST["oitodez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"]; 
 
$zeroum = ($zeroum*100)/$nPessoas;
$doisquatro = ($doisquatro*100)/$nPessoas;
$cinco = ($cinco*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$oitodez = ($oitodez*100)/$nPessoas;

$zeroum = number_format($zeroum,1,".","");
$doisquatro = number_format($doisquatro,1,".","");
$cinco = number_format($cinco,1,".","");
$media = number_format($media,1,".","");
$oitodez = number_format($oitodez,1,".","");

$soma = $zeroum+$doisquatro+$cinco+$media+$oitodez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zeroum,$doisquatro,$cinco,$media,$oitodez);

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

$lang = $_GET["lang"];
// Legends
$item = array();
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Decisão'");
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

$p1->SetLegends(array("$zeroum%% ".$item[0],"$doisquatro%% ".$item[1],"$cinco%% ".$item[2],"$media%% ".$item[3],"$oitodez%% ".$item[4]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/decisao.png");
?>


