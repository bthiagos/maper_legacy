<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

//if($_REQUEST["teste"]){
	
//	session_start();
	$id = $_REQUEST["cod"];

	$sql = " SELECT * FROM testes_gratuitos WHERE id = '$cod'";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	//echo $sql;
	$total = $linha["resposta"];
	
	$respostas = explode("|",$total);
	
	//echo "<br>".$respostas[3];
	//}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<style>
.td01 {
border: 1px #333333 solid;
border-bottom: 0px;
}

.td02 {
	border: 1px #333333 solid;
	border-bottom: 0px;
	border-left: 0px;
}

.td03 {
	border: 1px #333333 solid;
}
		
		
.td04 {
	border: 1px #333333 solid;
	border-left: 0px;
}
		
.tx_preto {
	color: #000000;
}
		
		
.fundo_claro {
	background: #ffffff;
}

.fundo_escuro {
background: #cccccc;
}
		
</style>
<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">			
			
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<b>Avaliação Gerencial</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
			
			<p style="margin-left: 15px"><b>Legenda:</b></p>
				<p style="margin-left: 15px">
					CS – Criança Submissa<br />
					CL – Criança Livre<br />
					CR – Criança Rebelde<br />
					A - Adulto<br />
					PN – Pai nutritivo<br />
					PC – Pai crítico<br />
				</p>

					<table width="96%" border="0" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="12" align="center" class="td01"><b>GRUPOS</b></td>
							</tr>
							
							<tr align="center">
								<td colspan="2" width="16%" class="td01 fundo_claro"><b>CS</b></td>
								<td colspan="2" width="16%" class="td02 fundo_escuro"><b>CR</b></td>
								<td colspan="2" width="16%" class="td02 fundo_claro"><b>CL</b></td>
								<td colspan="2" width="16%" class="td02 fundo_escuro"><b>A</b></td>
								<td colspan="2" width="16%" class="td02 fundo_claro"><b>PN</b></td>
								<td colspan="2" width="16%" class="td02 fundo_escuro"><b>PC</b></td>
							</tr>
						
					
							<?
							$coluna_cs = 0;
							$coluna_cr = 0;
							$coluna_cl = 0;
							$coluna_a = 0;
							$coluna_pn = 0;
							$coluna_pc = 0;
							
							?>
						
							
							<tr align="center">
								<td class="td03 fundo_claro"><b>Ítem</b></td>
								<td class="td04 fundo_claro"><b>Pts</b>.</td>
								<td class="td04 fundo_escuro"><b>Ítem</b></td>
								<td class="td04 fundo_escuro"><b>Pts</b>.</td>
								<td class="td04 fundo_claro"><b>Ítem</b></td>
								<td class="td04 fundo_claro"><b>Pts</b>.</td>
								<td class="td04 fundo_escuro"><b>Ítem</b></td>
								<td class="td04 fundo_escuro"><b>Pts</b>.</td>
								<td class="td04 fundo_claro"><b>Ítem</b></td>
								<td class="td04 fundo_claro"><b>Pts</b>.</td>
								<td class="td04 fundo_escuro"><b>Ítem</b></td>
								<td class="td04 fundo_escuro"><b>Pts</b>.</td>				
							</tr>
						
							<tr align="center">
								<td colspan="12">&nbsp;</td>
							</tr>
							
							<tr align="center">
							
							<!-- COLUNA CS -->
							
								<td class="td01 fundo_claro">02</td>			
								<td class="td02 fundo_claro">
								<?=$respostas[1];
								
								$coluna_cs += $respostas[1];
								?>
								</td>
							<!--COLUNA CS -->
							
							<!--COLUNA CR -->
								<td class="td02 fundo_escuro">06</td>
								<td class="td02 fundo_escuro">
								
								<?=$respostas[5];
								
								$coluna_cr += $respostas[5];
								?>
								
								</td>				
							<!--COLUNA CR -->
							
							<!--COLUNA CL -->
								<td class="td02 fundo_claro">01</td>
								<td class="td02 fundo_claro">
									
								<?=$respostas[0];
								
								$coluna_cl += $respostas[0];
								?>
								</td>
							<!--COLUNA CR -->
							
							<!--COLUNA A -->
								<td class="td02 fundo_escuro">04</td>
								<td class="td02 fundo_escuro">
								
								<?=$respostas[3];
								
								$coluna_a += $respostas[3];
								?>
								
								</td>
							<!--COLUNA A -->
							
							<!--COLUNA PN -->
								<td class="td02 fundo_claro">03</td>
								<td class="td02 fundo_claro">
								
								<?=$respostas[2];
								
								$coluna_pn += $respostas[2];
								?>
								
								</td>
							<!--COLUNA PN -->	
							
							<!--COLUNA PC -->
								<td class="td02 fundo_escuro">07</td>
								<td class="td02 fundo_escuro">
								
								<?=$respostas[6];
								
								$coluna_pc += $respostas[6];
								?>
								
								</td>
							<!--COLUNA PC -->
							</tr>
							
							
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">05</td>
								<td class="td02 fundo_claro">
								<?=$respostas[4];
								
								$coluna_cs += $respostas[4];
								?>
								</td>
							<!-- COLUNA CS -->
							
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">11</td>
								<td class="td02 fundo_escuro">
								<?=$respostas[10];
								
								$coluna_cr += $respostas[10];
								?>
								</td>
							<!-- COLUNA CR -->
							
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">10</td>
							
								<td class="td02 fundo_claro">
									<?=$respostas[9];
								
								$coluna_cl += $respostas[9];
								?>
								</td>
							<!-- COLUNA CL -->
							
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">08</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[7];
								
								$coluna_a += $respostas[7];
								?>
								</td>
							<!-- COLUNA A -->	
							
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">09</td>
								<td class="td02 fundo_claro">
									<?=$respostas[8];
								
								$coluna_pn += $respostas[8];
								?>
								</td>
							<!-- COLUNA PN -->
							
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">12</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[11];
								
								$coluna_pc += $respostas[11];
								?>
								</td>
							<!-- COLUNA PC -->
							</tr>
							
							
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">16</td>
								<td class="td02 fundo_claro">
									<?=$respostas[15];
								
								$coluna_cs += $respostas[15];
								?>
								</td>
							<!-- COLUNA CS -->
							
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">19</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[18];
								
								$coluna_cr += $respostas[18];
								?>
								</td>
							<!-- COLUNA CR -->
							
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">15</td>
								<td class="td02 fundo_claro">
									<?=$respostas[14];
								
								$coluna_cl += $respostas[14];
								?>
								</td>
							<!-- COLUNA CL -->
							
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">14</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[13];
								
								$coluna_a += $respostas[13];
								?>
								</td>
							<!-- COLUNA A -->
							
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">18</td>
								<td class="td02 fundo_claro">
									<?=$respostas[17];
								
								$coluna_pn += $respostas[17];
								?>
								</td>
							<!-- COLUNA PN -->
							
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">13</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[12];
								
								$coluna_pc += $respostas[12];
								?>
								</td>
							<!-- COLUNA PC -->
							</tr>
							
							
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">24</td>
								<td class="td02 fundo_claro">
									<?=$respostas[23];
								
								$coluna_cs += $respostas[23];
								?>
								</td>
							<!-- COLUNA CS -->
							
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">23</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[22];
								
								$coluna_cr += $respostas[22];
								?>
								</td>
							<!-- COLUNA CR -->
							
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">21</td>
								<td class="td02 fundo_claro">	<?=$respostas[20];
								
								$coluna_cl += $respostas[20];
								?></td>
							<!-- COLUNA CL -->			
							
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">17</td>
								<td class="td02 fundo_escuro">	<?=$respostas[16];
								
								$coluna_a += $respostas[16];
								?></td>
							<!-- COLUNA A -->
							
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">22</td>
								<td class="td02 fundo_claro">	<?=$respostas[21];
								
								$coluna_pn += $respostas[21];
								?></td>
							<!-- COLUNA PN -->
							
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">20</td>
								<td class="td02 fundo_escuro">	<?=$respostas[19];
								
								$coluna_pc += $respostas[19];
								?></td>
							<!-- COLUNA PC -->
							</tr>
							
						
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">31</td>
								<td class="td02 fundo_claro">
									<?=$respostas[30];
								
								$coluna_cs += $respostas[30];
								?>
								</td>			
							<!-- COLUNA CS -->			
							
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">25</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[24];
								
								$coluna_cr += $respostas[24];
								?>
								</td>			
							<!-- COLUNA CR -->	
							
							
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro ">28</td>
								<td class="td02 fundo_claro">
									<?=$respostas[27];
								
								$coluna_cl += $respostas[27];
								?>
								</td>			
							<!-- COLUNA CL -->
							
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">10</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[9];
								
								$coluna_a += $respostas[9];
								?>
								</td>
							<!-- COLUNA A -->
							
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">26</td>
								<td class="td02 fundo_claro">
									<?=$respostas[25];
								
								$coluna_pn += $respostas[25];
								?>
								</td>
							<!-- COLUNA PN -->	
							
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">27</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[26];
								
								$coluna_pc += $respostas[26];
								?>
								</td>
							<!-- COLUNA PC -->
							</tr>
						
						
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">34</td>
								<td class="td02 fundo_claro">
									<?=$respostas[33];
								
								$coluna_cs += $respostas[33];
								?></td>
							<!-- COLUNA CS -->
								
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">29</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[28];
								
								$coluna_cr += $respostas[28];
								?>
								</td>
							<!-- COLUNA CR -->
								
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">33</td>
								<td class="td02 fundo_claro">	<?=$respostas[32];
								
								$coluna_cl += $respostas[32];
								?></td>
							<!-- COLUNA CL -->
							
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">35</td>
								<td class="td02 fundo_escuro">	<?=$respostas[34];
								
								$coluna_a += $respostas[34];
								?></td>
							<!-- COLUNA A -->
								
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">32</td>
								<td class="td02 fundo_claro">	<?=$respostas[31];
								
								$coluna_pn += $respostas[31];
								?></td>
							<!-- COLUNA PN -->
								
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">36</td>
								<td class="td02 fundo_escuro">	<?=$respostas[36];
								
								$coluna_pc += $respostas[36];
								?></td>
							<!-- COLUNA PC -->
							</tr>
						
							
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">40</td>
								<td class="td02 fundo_claro">	<?=$respostas[39];
								
								$coluna_cs += $respostas[39];
								?></td>
							<!-- COLUNA CS -->
								
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">39</td>
								<td class="td02 fundo_escuro">	<?=$respostas[38];
								
								$coluna_cr += $respostas[38];
								?></td>
							<!-- COLUNA CR -->
								
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">38</td>
								<td class="td02 fundo_claro">
									<?=$respostas[37];
								
								$coluna_cl += $respostas[37];
								?>
								</td>
							<!-- COLUNA CL -->
								
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">44</td>
								<td class="td02 fundo_escuro">
									<?=$respostas[43];
								
								$coluna_a += $respostas[43];
								?>
								</td>
							<!-- COLUNA A -->
								
							<!-- COLUNA PN -->
								<td class="td02 fundo_claro">42</td>
								<td class="td02 fundo_claro">	<?=$respostas[41];
								
								$coluna_pn += $respostas[41];
								?></td>
							<!-- COLUNA PN -->
								
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">37</td>
								<td class="td02 fundo_escuro">	<?=$respostas[36];
								
								$coluna_pc += $respostas[36];
								?></td>
							<!-- COLUNA PC -->
							</tr>
						
						
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">47</td>
								<td class="td02 fundo_claro">	<?=$respostas[46];
								
								$coluna_cs += $respostas[46];
								?></td>
							<!-- COLUNA CS -->	
								
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">45</td>
								<td class="td02 fundo_escuro">	<?=$respostas[44];
								
								$coluna_cr += $respostas[44];
								?></td>
							<!-- COLUNA CR -->
								
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">41</td>
								<td class="td02 fundo_claro">	<?=$respostas[40];
								
								$coluna_cl += $respostas[40];
								?></td>
							<!-- COLUNA CL -->
								
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">48</td>
								<td class="td02 fundo_escuro">	<?=$respostas[47];
								
								$coluna_a += $respostas[47];
								?></td>
							<!-- COLUNA A -->
								
							<!-- COLUNA PN -->	
								<td class="td02 fundo_claro">43</td>
								<td class="td02 fundo_claro">	<?=$respostas[42];
								
								$coluna_pn += $respostas[42];
								?></td>
							<!-- COLUNA PN -->
								
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">46</td>
								<td class="td02 fundo_escuro">	<?=$respostas[45];
								
								$coluna_pc += $respostas[45];
								?></td>
							<!-- COLUNA PC -->
							</tr>
						
						
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td01 fundo_claro">49</td>
								<td class="td02 fundo_claro">	<?=$respostas[48];
								
								$coluna_cs += $respostas[48];
								?></td>
							<!-- COLUNA CS -->
							
							<!-- COLUNA CR -->
								<td class="td02 fundo_escuro">50</td>
								<td class="td02 fundo_escuro">	<?=$respostas[49];
								
								$coluna_cr += $respostas[49];
								?></td>
							<!-- COLUNA CR -->
								
							<!-- COLUNA CL -->
								<td class="td02 fundo_claro">52</td>
								<td class="td02 fundo_claro">	<?=$respostas[51];
								
								$coluna_cl += $respostas[51];
								?></td>
							<!-- COLUNA CL -->
								
							<!-- COLUNA A -->
								<td class="td02 fundo_escuro">56</td>
								<td class="td02 fundo_escuro">	<?=$respostas[55];
								
								$coluna_a += $respostas[55];
								?></td>
							<!-- COLUNA A -->
								
							<!-- COLUNA PN -->	
								<td class="td02 fundo_claro">54</td>
								<td class="td02 fundo_claro">	<?=$respostas[53];
								
								$coluna_pn += $respostas[53];
								?></td>
							<!-- COLUNA PN -->
								
							<!-- COLUNA PC -->
								<td class="td02 fundo_escuro">51</td>
								<td class="td02 fundo_escuro">	<?=$respostas[50];
								
								$coluna_pc += $respostas[50];
								?></td>
							<!-- COLUNA PC -->
							</tr>
						
							
							<tr align="center">
							
							<!-- COLUNA CS -->
								<td class="td03 fundo_claro">53</td>
								<td class="td04 fundo_claro">	<?=$respostas[52];
								
								$coluna_cs += $respostas[52];
								?></td>
							<!-- COLUNA CS -->	
								
							<!-- COLUNA CR -->
								<td class="td04 fundo_escuro">57</td>
								<td class="td04 fundo_escuro">	<?=$respostas[56];
								
								$coluna_cr += $respostas[56];
								?></td>
							<!-- COLUNA CR -->
								
							<!-- COLUNA CL -->
								<td class="td04 fundo_claro">55</td>
								<td class="td04 fundo_claro">	<?=$respostas[54];
								
								$coluna_cl += $respostas[54];
								?></td>
							<!-- COLUNA CL -->
								
							<!-- COLUNA A -->
								<td class="td04 fundo_escuro">59</td>
								<td class="td04 fundo_escuro">	<?=$respostas[58];
								
								$coluna_a += $respostas[58];
								?></td>
							<!-- COLUNA A -->
								
							<!-- COLUNA PN -->	
								<td class="td04 fundo_claro">58</td>
								<td class="td04 fundo_claro">	<?=$respostas[57];
								
								$coluna_pn += $respostas[57];
								?></td>
							<!-- COLUNA PN -->
								
							<!-- COLUNA PC -->
								<td class="td04 fundo_escuro">60</td>
								<td class="td04 fundo_escuro">	<?=$respostas[59];
								
								$coluna_pc += $respostas[59];
								?></td>
							<!-- COLUNA PC -->
							</tr>
							
							<tr align="center">
								<td colspan="12">&nbsp;</td>
							</tr>
							<tr align="center">
							
								<td class="td03 fundo_claro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_claro"><b><?=$coluna_cs;?></b></td>
								
								
								<td class="td04 fundo_escuro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_escuro"><b><?=$coluna_cr;?></b></td>
								
								
								<td class="td04 fundo_claro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_claro"><b><?=$coluna_cl;?></b></td>
								
								
								<td class="td04 fundo_escuro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_escuro"><b><?=$coluna_a;?></b></td>
								
								
								<td class="td04 fundo_claro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_claro"><b><?=$coluna_pn;?></b></td>
								
								
								<td class="td04 fundo_escuro"><b>TOTAL</b></td>
								<td class="td04 tx_preto fundo_escuro"><b><?=$coluna_pc;?></b></td>
							</tr>
										
							
							<tr align="center">
								<td colspan="12">&nbsp;</td>
							</tr>
							<tr align="center">
								<td colspan="12">&nbsp;</td>
							</tr>
							
							<tr align="center">
								<td colspan="12" class="td01"><b>Equilíbrio</b></td>
							</tr>
							
							<tr align="center">
								<td class="td03 fundo_claro"><b>CS</b></td>
								<td class="td04 tx_preto fundo_claro"><b>7 - 11,1</b></td>
								<td class="td04 fundo_escuro"><b>CR</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>5 - 9</b></td>
								<td class="td04 fundo_claro"><b>CL</b></td>
								<td class="td04 tx_preto fundo_claro"><b>10 - 14,1</b></td>
								<td class="td04 fundo_escuro"><b>A</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>22 - 28,1</b></td>
								<td class="td04 fundo_claro"><b>PN</b></td>
								<td class="td04 tx_preto fundo_claro"><b>11 - 15,1</b></td>
								<td class="td04 fundo_escuro"><b>PC</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>13,2</b></td>
							</tr>
							<tr align="center"><tr>
								<td colspan="12">&nbsp;</td>
							</tr>
							<tr align="center">
								<td colspan="12">&nbsp;</td>
							</tr>
							
							<tr align="center">
								<td colspan="12" class="td01"><b>Média de executivos brasileiros bem sucedidos</b></td>
							</tr>
							
							<tr align="center">
								<td class="td03 fundo_claro"><b>CS</b></td>
								<td class="td04 tx_preto fundo_claro"><b>8,8</b></td>
								<td class="td04 fundo_escuro"><b>CR</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>7,2</b></td>
								<td class="td04 fundo_claro"><b>CL</b></td>
								<td class="td04 tx_preto fundo_claro"><b>11,5</b></td>
								<td class="td04 fundo_escuro"><b>A</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>24,3</b></td>
								<td class="td04 fundo_claro"><b>PN</b></td>
								<td class="td04 tx_preto fundo_claro" ><b>12,7</b></td>
								<td class="td04 fundo_escuro"><b>PC</b></td>
								<td class="td04 tx_preto fundo_escuro"><b>10,8</b></td>
							</tr>					
						
					</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
			
			
			
			
				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>