<?php
include ("src/jpgraph.php");
include ("src/jpgraph_line.php");
include ("src/jpgraph_bar.php");
include ("conn.php");


	$sql = "SELECT * FROM nota WHERE cod_usuario = cod";
		$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					
				if ($linha["nota"] <= 4) {
					
					$l2datay3 = array($linha["nota"]);
					$l2datay1 = array(1);
					$l2datay2 = array(1);
				}
					

				if ($linha["nota"] >= 5 or $linha["nota"] <= 7) {
					
					$l2datay2 = array($linha["nota"]);
					$l2datay1 = array(1);
					$l2datay3 = array(1);
				}
				
					
				if ($linha["nota"] >= 8) {
					
					$l2datay1 = array($linha["nota"]);
					$l2datay2 = array(1);
					$l2datay3 = array(1);
				}
					
					
				}



$l1datay = array(7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7);




$datax=array("","Planejamento","Organiza��o","Acompanhamento","Lideran�a","Comunica��o","Decis�o","Detalhismo","T. de Execu��o","Intens.Operacional","Flex./Criatividade","Percep��o","Adap.� mudan�as","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realiza��o");

// Create the graph. 
$graph = new Graph(950,700,"auto");    
$graph->SetScale("textint",1,10);
//$graph->SetYScale("lin");


$graph->img->SetMargin(40,170,20,140);
$graph->SetMarginColor("#ffffff");
$graph->SetShadow();


// Create the linear error plot
$l1plot=new LinePlot($l1datay);
$l1plot->SetColor("red");
$l1plot->SetWeight(2);
$l1plot->SetLegend("Desempenho Ideal");
$graph->legend->Pos(0.0,0.1,"right","center");




				
			
	



// Create the bar plot

	$bplot1 = new BarPlot($l2datay1);
	$bplot1->SetFillColor("blue");
	$bplot1->SetLegend("Fator de Sustenta��o");
	
	$bplot2 = new BarPlot($l2datay2);
	$bplot2->SetFillColor("yellow");
	$bplot2->SetLegend("Fator Aceit�vel");

	$bplot3 = new BarPlot($l2datay3);
	$bplot3->SetFillColor("red");
	$bplot3->SetLegend("Fator Cr�tico");

	

// ...and add it to the graPH
//$graph->Add($gbplot);


// Add the plots to t'he graph

$graph->Add($bplot1);
$graph->Add($bplot2);
$graph->Add($bplot3);
$graph->Add($l1plot);


$graph->title->Set("Avalia��o do Potencial e Perfil - "  );
//$graph->xaxis->title->Set("X-title");
//$graph->yaxis->title->Set("Y-title");


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
$graph->Stroke();
?>