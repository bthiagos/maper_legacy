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
	$m_questao = $respostas[0];
	$n_questao = $respostas[1];
	$r_questao = $respostas[2];
	$d_questao = $respostas[3];
	$p_questao = $respostas[4];
	
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
				<b>Posi��es Existenciais</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
				<p><b>Resultado</b>:</p>
					
					
					<div style="width:100%; float:left;">
						<table width="40%" border="0" align="left">
							<tr>
								<td width="90px">TOTAL</td>
								<td width="10px" align="center"><?=$m_questao?></td>							
								<td width="10px" align="center"><?=$n_questao?></td>							
								<td width="10px" align="center"><?=$r_questao?></td>							
								<td width="10px" align="center"><?=$d_questao?></td>							
								<td width="10px" align="center"><?=$p_questao?></td>							
							</tr>
							
							<tr>
								<td width="90px">&nbsp;</td>
								<td width="10px" align="center">M</td>							
								<td width="10px" align="center">N</td>
								<td width="10px" align="center">R</td>							
								<td width="10px" align="center">D</td>							
								<td width="10px" align="center">P</td>							
							</tr>
							
							<tr>
								<td width="90px">Percentual</td>
								<td width="10px" align="center">
								
									<?
									$m_percentual = (($m_questao * 100) / 20);
									//$m_percentual = $m_questao * 100 ;
									echo $m_percentual."%";
									?>
							
								</td>							
								<td width="10px" align="center">
								
									<?
									$n_percentual = (($n_questao * 100) / 20);
									//$n_percentual = $n_questao * 100 ;
									echo $n_percentual."%";
									
									?>
								
								</td>							
								<td width="10px" align="center">
									
									<?
									$r_percentual = (($r_questao * 100) / 20);
									//$n_percentual = $n_questao * 100 ;
									echo $r_percentual."%";
									
									?>
								</td>							
								<td width="10px" align="center">
									<?
										
									$d_percentual = (($d_questao * 100) / 20);
									//$n_percentual = $n_questao * 100 ;
									echo $d_percentual."%";
									
									
									
									?>
								</td>							
								<td width="10px" align="center">
									<?
										
									$p_percentual = (($p_questao * 100) / 20);
									//$n_percentual = $n_questao * 100 ;
									echo $p_percentual."%";
									
									
									
									?>
								</td>							
							</tr>
							
						
					</table>
					</div>
				
					<p style="margin-top: 5px; margin-left: 15px">
					
					<b>Legenda:</b><br />
						M � Man�aca<br />
						N � Nihilista<br />
						R � Realista<br />
						D � Depressiva <br />
						P � Projetiva<br />
					</p>
					
					
					<p>
					<b>POSI��ES EXISTENCIAIS </b>
					</p>

					<p>
						<b>Realista </b><br/><br/>
						�	Mant�m um equil�brio interno e externo<br/>
						�	Aceitam aspectos, tanto positivos quanto negativos<br/>
						�	Objetivos<br/>
						�	Desfrutam <br/>
						�	Decis�es conscientes<br/>
						�	Mant�m uma atitude de otimismo realista<br/>
						�	Aberto � cr�ticas <br/>
						�	Sinceros <br/>
						�	Conhecem suas limita��es e as dos outros <br/>
						�	Ger�ncia situacional<br/>
						</p>
						
						<p><b>
						Man�aca </b><br/><br/>
						�	Vivem num mundo �cor-de-rosa�<br/>
						�	Oba-oba constante<br/>
						�	Resistentes � cr�tica<br/>
						�	Justificam seus erros e dos outros<br/>
						�	Funcion�rios super confiantes em si mesmo e nos outros <br/>
						�	Geralmente dif�ceis em empresas ( �caem f�cil do cavalo,     entrando em -/- : posi��o nihilista)<br/>
						�	Ger�ncia �deixa acontecer�<br/>
						</p>
						
						<p><b>
						Nihilista </b><br/><br/>
						�	Negam e/ou desqualificam a si mesmo e aos demais<br/>
						�	Tristes, deprimidos <br/>
						�	Pessimistas <br/>
						�	Desanimados, inertes <br/>
						�	Possibilidade de homic�dio ou suic�dio<br/>
						�	Pouco persistentes no trabalho<br/>
						�	Causam mal � estar no grupo<br/>
						�	Geralmente demitidos<br/>
						</p>
						
						<p><b>
						Projetiva </b><br/><br/>
						�	Desconfiados <br/>
						�	Culpam os outros <br/>
						�	Perseguidores<br/>
						�	Buscam defeitos nos outros<br/>
						�	R�gidos<br/>
						�	N�o aceitam opini�es <br/>
						�	Centralizadores<br/>
						�	Contestadores <br/>
						�	Ger�ncia autocr�tica<br/>
						
						</p>
						
						<p><b>
						Depressiva  </b><br/><br/>
						�	Pouco confiantes em si mesmos<br/>
						�	Buscam os outros <br/>
						�	Inseguros <br/>
						�	Dependentes, incapazes<br/>
						�	T�midos <br/>
						�	Indecisos <br/>
						�	Pouco din�micos <br/>
						�	Pessimistas <br/>
						�	Ger�ncia bem �participativa�, em que os outros tomam as decis�es.<br/>
						
								
								</p>
			
			
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