|S<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');


$umdois = $_REQUEST["umdois"];
$zero = $_REQUEST["zero"];
$tres= $_REQUEST["tres"]; 
$cincodez= $_REQUEST["cincodez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];

$umdois = ($umdois*100)/$nPessoas;
$media = ($media*100)/$nPessoas;
$zero = ($zero*100)/$nPessoas;
$tres= ($tres*100)/$nPessoas;
$cincodez= ($cincodez*100)/$nPessoas;

$umdois = number_format($umdois,1,".","");
$media = number_format($media,1,".","");
$zero = number_format($zero,1,".","");
$tres= number_format($tres,1,".","");
$cincodez= number_format($cincodez,1,".","");

$soma = $zero+$umdois+$tres+$media+$cincodez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}
// Some data
$data = array($zero,$umdois,$tres,$media,$cincodez);

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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Auto-imagem'");
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

$p1->SetLegends(array("$zero%% ".$item[0],"$umdois%% ".$item[1],"$tres%% ".$item[2],"$media%% ".$item[3],"$cincodez%% ".$item[4]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/autoimagem.png");
?>


