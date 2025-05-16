<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

$zero = $_REQUEST["zero"];
$umdois = $_REQUEST["umdois"]; 
$tres = $_REQUEST["tres"];
$sete = $_REQUEST["sete"];
$oitonove = $_REQUEST["oitonove"]; 
$dez  = $_REQUEST["dez"];
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];

$zero = ($zero*100)/$nPessoas;
$umdois = ($umdois*100)/$nPessoas;
$tres = ($tres*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$sete = ($sete*100)/$nPessoas;
$oitonove = ($oitonove*100)/$nPessoas;
$dez = ($dez*100)/$nPessoas;

$zero = number_format($zero,1,".","");
$umdois = number_format($umdois,1,".","");
$tres = number_format($tres,1,".","");
$media = number_format($media,1,".","");
$sete = number_format($sete,1,".","");
$oitonove = number_format($oitonove,1,".","");
$dez = number_format($dez,1,".","");

$soma = $zero+$umdois+$tres+$sete+$media+$oitonove+$dez;
if($soma < 100){
	$media = 100-$soma+$media;
}elseif($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zero,$umdois,$tres,$media,$sete,$oitonove,$dez);

// Create the Pie Graph. 
$graph = new PieGraph(900,700);
$graph->img->SetMargin(20,20,20,420); 

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
$p1->value->SetFont(FF_FONT2,FS_BOLD);
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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Planejamento'");
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

$p1->SetLegends(array("$zero%% ".$item[0],"$umdois%% ".$item[1],"$tres%% ".$item[2],"$media%% ".$item[3],"$sete%% ".$item[4],"$oitonove%% ".$item[5],"$dez%% ".$item[6]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/planejamento.png");
?>