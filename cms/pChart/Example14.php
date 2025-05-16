<?php
 /*
     Example14: A smooth flat pie graph
 */

 // Standard inclusions   
 include("pChart/pData.class");
 include("pChart/pChart.class");

 // Dataset definition 
 $DataSet = new pData;
 $DataSet->AddPoint(array(500,400),"Serie1");
 $DataSet->AddPoint(array("Alternativa C","Alternativa D"),"Serie2");
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(800,600);
 $Test->loadColorPalette("Sample/softtones.txt");

 // Draw the pie chart
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->AntialiasQuality = 0;
 $Test->drawBasicPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),400,300,250,PIE_PERCENTAGE);
 $Test->drawPieLegend(630,50,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 $Test->Render("example14.png");
?>