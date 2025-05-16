<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

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
				<img src="imagens/tit_avaliacao_cargos.gif" alt="AVALIAÇÕES DE CARGOS" title="AVALIAÇÕES DE CARGOS" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="result_avaliacao_cargos.php" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
		
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
				<select name="orga" class="form_style" onchange="javascript:busca_cargos(1,this.value);">
				<option value="Selecione">Selecione</option>
				<?
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($fabricante == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
			
				
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Cargos: </span> </div>
				<select name="id_cargo" id="id_cargo" class="form_style">
					<option value="0">Selecione</option>
				</select>
			</div>	
			
			<!-- INICIO  AVALIACAO I  COMPETENCIA	-->
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Competência: </span> </div>
					
					<select name="linha_competencia" id="linha_competencia" class="form_style">
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="E">E</option>
						<option value="F">F</option>
						<option value="G">G</option>
						<option value="H">H</option>
						<option value="I">I</option>
					</select>
					<select name="sinal_competencia" id="sinal_competencia" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>	
					
					
					&nbsp;
					<select name="cl_princ_competencia" id="cl_princ_competencia" class="form_style">
						<option value="i">I</option>
						<option value="ii">II</option>
						<option value="iii">III</option>
						<option value="iv">IV</option>
					</select>					
					<select name="cl_princ_sinal_competencia" id="cl_princ_competencia" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
					
					&nbsp;
					<select name="cl_seg_competencia" id="cl_seg_competencia" class="form_style">
						<option value="X">X</option>
						<option value="Y">Y</option>
						<option value="Z">Z</option>
					</select>					
					<select name="cl_seg_sinal_competencia" id="cl_seg_competencia" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
				</div>	
			<!-- FIM  AVALIACAO I  COMPETENCIA	-->
			
			
			<!-- INICIO AVALIACAO II  CAPACIDADE DECISORIA	-->
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Capacidade Decisória: </span> </div>
				
				<select name="linha_capacidade_decisoria" class="form_style">
					<OPTION VALUE="A">A</OPTION>
					<OPTION VALUE="B">B</OPTION>
					<OPTION VALUE="C">C</OPTION>
					<OPTION VALUE="D">D</OPTION>
					<OPTION VALUE="E">E</OPTION>
					<OPTION VALUE="F">F</OPTION>
					<OPTION VALUE="G">G</OPTION>
					<OPTION VALUE="H">H</OPTION>
				</select>
				
				
				<select name="simbolo_capacidade_decisoria1" class="form_style">
					<option value="0">0</option>
					<option value="+">+</option>
				</select>
				
				&nbsp;
				
				<select name="coluna_capacidade_decisoria" class="form_style">
					<option value="i">I</option>
					<option value="ii">II</option>
					<option value="iii">III</option>
					<option value="iv">IV</option>
					<option value="v">V</option>
				</select>
				
				
				<select name="simbolo_capacidade_decisoria2" class="form_style">
					<option value="0">0</option>
					<option value="+">+</option>
				</select>
			</div>	
			<!-- FIM  AVALIACAO II  CAPACIDADE DECISORIO	-->	
			
			
			
			
			<!-- INICIO AVALIACAO III  RESULTADO FUNCIONAIS	-->
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Resultado Funcionais: </span> </div>
				
					<select name="linha_resultados_finais" class="form_style">
						<OPTION VALUE="A">A</OPTION>
						<OPTION VALUE="B">B</OPTION>
						<OPTION VALUE="C">C</OPTION>
						<OPTION VALUE="D">D</OPTION>
						<OPTION VALUE="E">E</OPTION>
						<OPTION VALUE="F">F</OPTION>
						<OPTION VALUE="G">G</OPTION>
						<OPTION VALUE="H">H</OPTION>
						<OPTION VALUE="I">I</OPTION>
					</select>
					
					<select name="simbolo_resultados_finais1" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
					&nbsp;
					
					<select name="coluna_resultados_finais_principal" class="form_style">
						<option value="i">I</option>
						<option value="ii">II</option>
						<option value="iii">III</option>
						<option value="iv">IV</option>
						<option value="v">V</option>
						<option value="vi">VI</option>
					</select>
					
					<select name="simbolo_resultados_finais2" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
					&nbsp;
					
					<select name="coluna_resultados_finais_secundaria" class="form_style">
						<option value="w">W</option>
						<option value="x">X</option>
						<option value="y">Y</option>
						<option value="z">Z</option>
					</select>
					
					<select name="simbolo_resultados_finais3" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
			</div>	
			<!-- FIM  AVALIACAO III  RESULTADO FUNCIONAIS	-->
			
			
			
			<!-- INICIO AVALIACAO IV   CONDIÇÕES DE TRABALHO	-->
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Condições de Trabalho: </span> </div>
			
					<select name="linha_condicoes_trabalho" class="form_style">
						<OPTION VALUE="A">A</OPTION>
						<OPTION VALUE="B">B</OPTION>
						<OPTION VALUE="C">C</OPTION>
						<OPTION VALUE="D">D</OPTION>
					</select>
					
					<select name="simbolo_condicoes_trabalho1" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
					&nbsp;
					<select name="coluna_condicoes_trabalho_principal" class="form_style">
						<option value="i">I</option>
						<option value="ii">II</option>
						<option value="iii">III</option>
						<option value="iv">IV</option>
						<option value="v">V</option>
					</select>
					
					<select name="simbolo_condicoes_trabalho2" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
					&nbsp;
					<select name="coluna_condicoes_trabalho_secundaria" class="form_style">
						<option value="x">X</option>
						<option value="y">Y</option>
						<option value="z">Z</option>
					</select>
					
					<select name="simbolo_condicoes_trabalho3" class="form_style">
						<option value="-">-</option>
						<option value="0">0</option>
						<option value="+">+</option>
					</select>
			</div>	
			<!-- FIM  AVALIACAO IV   CONDIÇÕES DE TRABALHO	-->
				
				<p align="center"><input type="submit" value="Gerar Avaliação" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			
			
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>