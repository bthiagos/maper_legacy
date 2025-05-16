<?php

/* 
	REQUISITOS
	
	- Incluir pChart/pData.class
	- Incluir pChart/pChart.class
	- Incluir MPDF54/mpdf.php
	
*/

class PaginaRelatorio {
	
	var $id;
	var $pergunta;
	var $id_pesquisa;
	var $alternativas = array();
	var $respostas = array();	
	
	var $png_grafico;
	
	static $html;
	
	function PaginaRelatorio ($id, $nome, $id_pesquisa) {
		$this->id = $id;
		$this->pergunta = $nome;
		$this->id_pesquisa = $id_pesquisa;
	}
	
	function addAlternativa ($alternativa, $qtd_respostas) {
		if($alternativa == "" or $alternativa == NULL or !isset($alternativa)){
			$this->alternativas[] = "";
		}
		else {
			$this->alternativas[] = (string)$alternativa;
		}
		
		if($qtd_respostas == 0 or $qtd_respostas == "" or $qtd_respostas == NULL or !isset($qtd_respostas)){
			$this->respostas[] = 0;
		}
		else {
			$this->respostas[] =  intval($qtd_respostas);
		}
	}
	
	function geraGrafico () {
		
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->AddPoint($this->respostas,"Serie1");
		$DataSet->AddPoint($this->alternativas,"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie("Serie2");
		
		// Initialise the graph
		$Test = new pChart(300,200);
		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->drawFilledRoundedRectangle(7,7,293,193,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,295,195,5,230,230,230);
		
		// Draw the pie chart
		$Test->AntialiasQuality = 0;
		$Test->setShadowProperties(2,2,200,200,200);
		$Test->drawFlatPieGraphWithShadow($DataSet->GetData(),$DataSet->GetDataDescription(),120,100,60,PIE_PERCENTAGE,8);
		$Test->clearShadow();
		
		$Test->drawPieLegend(230,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
		
		$Test->Render("pc_graficos/pc_grafico_p".$this->id."_a".$this->id_pesquisa.".png");
		
		$this->png_grafico = "pc_grafico_p".$this->id."_a".$this->id_pesquisa.".png";
		
	}
	
	function geraPaginaPDF($num_pergunta) {
		
		$letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "U", "Z");
		
		$this->html .= '
			<html>	
				<body style="font-family: Arial">
					
					<h2 style="padding:40px 0 0 0; margin:0; font-size:16px">Pergunta '.str_pad($num_pergunta, 3, "0", STR_PAD_LEFT).':</h2>
					<h1 style="border:1px solid #797979; padding:05px 10px; font-size:22px">'.$this->pergunta.'</h1>
				
					<img src="pc_graficos/'.$this->png_grafico.'" />
									
					<p style="font-size:14px">';
		
		$count = 0;					
					
		foreach($this->alternativas as $alternativa){
			
			$this->html .= "<strong>Alternativa ".$letras[$count]." :</strong> ".$alternativa."<br />";
			
			$count++;
			
		}
					
		$this->html .= '
					</p>
					<pagebreak />
										
				</body>
			</html>
			';
				
	}
	
	function geraPDF($data) {
		
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
		
		$mpdf->WriteHTML(utf8_encode($data));
		$mpdf->Output();
		exit;
		
	}
	
}

?>