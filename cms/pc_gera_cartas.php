<? ob_start(); ?>
<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?php //include("pc_valida_id_pesquisa.php"); ?>


<?php

	// TRATAMENTO DE DADOS DA PESQUISA
	
	$id_pesquisa = $_POST['id_pesquisa'];
	
	// BUSCA A MENSAGEM DA CARTA
	
	$sql_msg = "SELECT descricao FROM pc_pesquisa WHERE id=$id_pesquisa LIMIT 1";
	$query_msg = mysql_query($sql_msg) or die(mysql_error());
	$msg_carta = mysql_result($query_msg, 0, 'descricao');
	
	// GERA CARTAS EM PDF

	$first = false;

	$html = '
	<html>	
		<body style="font-family: Arial">
			<p style="font-size:14px; font-family:Arial, Helvetica, sans-serif;">
				';
	
	foreach($_POST['codigo'] as $ticket){
				
		if($first != false){
						
			$html .= '<pagebreak />';						
		}
		
		$html .= str_replace("[TICKET]", "<strong><span style='font-size: 28px'>".$ticket."</span></strong>", utf8_encode(nl2br($msg_carta)));
		
		$first = true;
		
	}
			
	$html .=	'
			</p>
		</body>
	</html>
	';
?>

<?php
	include("MPDF54/mpdf.php");
	 
	$mpdf=new mPDF();
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;
	
?>