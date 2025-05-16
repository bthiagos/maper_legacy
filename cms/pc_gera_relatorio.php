<?php ini_set('display_errors', 1); ?>

<?php 
	include("conn.php"); 
	include("logon.php"); 
	include("library.php"); 
	include("pc_valida_id_pesquisa.php");
	
	include("MPDF54/mpdf.php");
	
	include("pChart/pChart/pData.class"); 
	include("pChart/pChart/pChart.class"); 
	
	include("pc_relatorio.class.php");
	
	include("wkHtmlToPdf.php");
	
?>

<?
	
	$html = "";

	$id_pesquisa = $_GET['id_pesquisa'];
	
	$sql_pergunta = "SELECT *
					FROM pc_pergunta
					WHERE id_pesquisa = $id_pesquisa
					ORDER BY ordem";
	$query_pergunta = mysql_query($sql_pergunta) or die(mysql_error());
	
	$count_pergunta = 1;
	
	while($linha_pergunta = mysql_fetch_array($query_pergunta)){
		
		// INICIALIZA PaginaRelatorio
		$pagina_relatorio = new PaginaRelatorio($linha_pergunta['id'], $linha_pergunta['pergunta'], $id_pesquisa);
		
		$sql_alternativas = "SELECT id, alternativa FROM pc_alternativa WHERE id_pergunta = ".$linha_pergunta['id']." ORDER BY campo_digitavel, alternativa";
		$query_alternativas = mysql_query($sql_alternativas) or die(mysql_error());
		
		if(mysql_num_rows($query_alternativas) > 0){
			
			while($linha_alternativa = mysql_fetch_array($query_alternativas)){
				
				$sql_respostas = "SELECT id_alternativa FROM pc_resposta WHERE id_alternativa=".$linha_alternativa['id']."";
				$query_respostas = mysql_query($sql_respostas) or die(mysql_error());
				
				$qtd = intval(mysql_num_rows($query_respostas));
				
				$pagina_relatorio->addAlternativa( $linha_alternativa['alternativa'] , $qtd);
					
			}
		}
		
		//$pagina_relatorio->geraGrafico();
		
		$pagina_relatorio->geraPaginaPDF($count_pergunta);	
		
		//$html .= $pagina_relatorio->html;
						
		$count_pergunta++;
						
	}
	
	/*
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
	</table>');
	
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output('pc_teste.pdf','D');
	exit;
	*/
	
	$pdf = new WkHtmlToPdf;
 	$pdf->addPage('http://google.com');
    $pdf->addToc();
  
    // Save the PDF
    $pdf->saveAs('pc_teste_new_pdf.pdf');
 
    // Send to client for inline display
    $pdf->send();
	
?>