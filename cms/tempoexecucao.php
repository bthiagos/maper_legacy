<?php // content="text/plain; charset=utf-8"
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_pie.php');
require_once ('conn.php');

//zeroum doistres quatro oitonove dez = 0;

$zeroum = $_REQUEST["zeroum"];
$doistres = $_REQUEST["doistres"];
$quatro = $_REQUEST["quatro"]; 
$oitonove = $_REQUEST["oitonove"]; 
$dez = $_REQUEST["dez"]; 
$media = $_REQUEST["media"];
$nPessoas = $_REQUEST["nPessoas"];

$zeroum = ($zeroum*100)/$nPessoas;
$doistres = ($doistres*100)/$nPessoas;
$quatro = ($quatro*100)/$nPessoas;
$oitonove = ($oitonove*100)/$nPessoas;
$dez = ($dez*100)/$nPessoas;
$media = ($media*100)/$nPessoas;

$zeroum = number_format($zeroum,1,".","");
$doistres = number_format($doistres,1,".","");
$quatro = number_format($quatro,1,".","");
$oitonove = number_format($oitonove,1,".","");
$dez = number_format($dez,1,".","");
$media = number_format($media,1,".","");

$soma = $zeroum+$doistres+$quatro+$media+$oitonove+$dez;
if($soma < 100){
	$media = 100-$soma+$media;
}
if($soma > 100){
	$media =  $media -($soma-100);
}

// Some data
$data = array($zeroum,$doistres,$quatro,$media,$oitonove,$dez);

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
$desc = mysql_query("SELECT * FROM feedbacks_grupo WHERE item = 'Tempo Execução'");
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

$p1->SetLegends(array("$zeroum%% ".$item[0],"$doistres%% ".$item[1],"$quatro%% ".$item[2],"$media%% ".$item[3],"$oitonove%% ".$item[4],"$dez%% ".$item[5]));
$graph->legend->SetFont(FF_FONT2,FS_NORMAL,16);
$graph->legend->Pos(0.01,0.01);

$graph->Add($p1);
$graph->Stroke("graficos_grupos/tempoexecucao.png");
?>


