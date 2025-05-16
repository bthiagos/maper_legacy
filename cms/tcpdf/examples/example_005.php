<?php

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('APP_WEB');
$pdf->SetTitle('APP_WEB');
$pdf->SetSubject('APP_WEB');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('arial', '', 7);

// add a page
$pdf->AddPage();


$pdf->writeHTML('

	<table width="511px" border="0" cellspacing="0" cellpadding="2"  align="left" style="font-size: 9">
		  <tr>
		    <td width="30px">&nbsp;</td>
		    <td width="145px"><b>Crit&eacute;rio</b></td>
		    <td width="36px"><b>Nota</b></td>
		    <td width="300px">Avaliacao</td>
		  </tr>
	</table>   '


, true, 0, true, 0);



$pdf->writeHTML('

	<table width="511px" border="0" cellspacing="0" cellpadding="2"  align="left" style="margin-top: 0px">
		  <tr>
		    <td width="30px">1</td>
		    <td width="145px">Planejamento <br /><br /> 0 1 2 3 4 5 6 7 8 9 10</td>
		    <td width="36px" align="center" style="vertical-align: middle;"><br /><br />7</td>
		    <td width="300px">Pessoa que apresenta algum equilíbrio entre planejamento e execução, com maior tendência à teorização. Interessa-se mais pelo planejamento do que pela execução. Tal atitude pode gerar certa frustração se não atingir suas metas por se deter em excesso na etapa do planejamento. Se tiver dificuldades com a capacidade organizativa, pode ser um mecanismo de compensação para suprir esta deficiência.</td>
		  </tr>
	</table>   '


, true, 0, true, 0);






// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_005.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
