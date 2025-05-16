<?php

	// Standard inclusions   
	include("pChart/pChart/pData.class");
	include("pChart/pChart/pChart.class");
	
	// Dataset definition 
	$DataSet = new pData;
	$DataSet->AddPoint(array(500,400),"Serie1");
	$DataSet->AddPoint(array("Alternativa C","Alternativa D"),"Serie2");
	$DataSet->AddAllSeries();
	$DataSet->SetAbsciseLabelSerie("Serie2");
	
	// Initialise the graph
	$Test = new pChart(800,600);
	$Test->loadColorPalette("pChart/Sample/softtones.txt");
	
	// Draw the pie chart
	$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
	$Test->AntialiasQuality = 0;
	$Test->drawBasicPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),400,300,250,PIE_PERCENTAGE);
	$Test->drawPieLegend(630,50,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
	
	$Test->Render("exadsfmple14.png");

	$html = '
	<html>	
		<body style="font-family: Arial">	
			<h2 style="padding:40px 0 0 0; margin:0; font-size:16px">Pergunta 001:</h2>
			<h1 style="border:1px solid #797979; padding:05px 10px; font-size:22px">Em que fase da vida você se considera?</h1>
		
			<img src="exadsfmple14.png" />
			
			
			<p style="font-size:14px"><strong>Alternativa A :</strong> Infância<br />
			<strong>Alternativa B :</strong> Adolecência<br />
			<strong>Alternativa C :</strong> Adulto<br />
			<strong>Alternativa D :</strong> Terceira-idade<br />
			<strong>Alternativa E :</strong> Outro</p>
			
		</body>
	</html>
	';
?>

</html>
<?php
	include("MPDF54/mpdf.php");
	 
	$mpdf=new mPDF();
	$mpdf->SetHTMLHeader('
	<table width="100%" style="vertical-align: bottom;color: #000000; border-bottom:2px solid #3e74cd; font-family:Arial">
		<tr>
			<td width="33%"><img src="appweb.png" /></td>
			<td width="33%" align="center" style="font-weight: bold;color:#3e74cd; font-size:18px;">Pesquisa de Clima<br />Empresa Contratante</td>
			<td width="33%" align="right" style="color:#797979; font-size:12px;">152/180<br />{DATE j/m/Y}</td>
		</tr>
	</table>
	'); 
	$mpdf->SetHTMLFooter('
	<table width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; font-weight: bold; border-top:1px solid #d8d8d8">
		<tr>
			<td width="33%" style="color:#3e74cd"><a hrer="http://www.appweb.com.br" style="color:#3e74cd">www.appweb.com.br</a></td>
			<td width="33%" align="center" style="font-weight: bold;color:#797979">{PAGENO}/{nbpg}</td>
			<td width="33%" style="text-align: right; color:#3e74cd">APP Web - Perfil profissional</td>
		</tr>
	</table>
');
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;
	
?>