<?php
include("library.php");

include ("src/jpgraph.php");
include ("src/jpgraph_bar.php");

			$v = $_REQUEST["v"];
			$w = $_REQUEST["w"];
			$x = $_REQUEST["x"];
			$y = $_REQUEST["y"];
			$z = $_REQUEST["z"];

$datay=array($v,$w,$x,$y,$z);
$datax=array("Fisiológicas","Segurança","Associação","Auto-estima","Auto-realização");

// Create the graph. These two calls are always required
$graph = new Graph(600,400,"auto");	
$graph->SetScale("textlin",0,36);


// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,140);
$graph->SetMarginColor("#ffffff");
$graph->SetShadow();

// Create a bar pot
$bplot = new BarPlot($datay);
$graph->Add($bplot);

// Setup the titles

// Label every 2:nd tick mark
$graph->xaxis->SetTextLabelInterval(1);

// Setup the labels
//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(90);

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$codigo_id = $v."_".$w."_".$x."_".$y."_".$z."_".".png";
// Display the graph
$graph->Stroke("motivograma/$codigo_id");
?>



