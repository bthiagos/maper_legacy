<?php


require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
	//$pdf->SetCreator(PDF_CREATOR);
	//$pdf->SetAuthor('Teste');
	$pdf->SetTitle('APPWEB - Avaliação de Potencial e Perfil Profissional');
	//$pdf->SetSubject('TCPDF Tutorial');
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
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// create some HTML content
$htmlcontent = '<img src="../../../logo_appweb.jpg" width="159" height="65" />';

// output the HTML content
$pdf->writeHTML($htmlcontent, true, 0, true, 0);

// output some RTL HTML content
$pdf->writeHTML('zzzzzzzzzzzzzzzzzzz', true, 0, true, 0);

// test some inline CSS
$inlinecss = 'xxxxxxxxxxxxxxxxxxxxxx';

$pdf->writeHTML($inlinecss, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();




//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
