<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?

$cargo = $_POST["id_cargo"];

$sql_cargo = "SELECT
				aplicacoes.cargo,
				organizacoes.nome as orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id WHERE aplicacoes.id =  $cargo";
$result_cargo = mysql_query($sql_cargo);
$linha_cargo = mysql_fetch_assoc($result_cargo);
$cargo_nome = $linha_cargo["cargo"];
$orga_nome = $linha_cargo["orga"];




/////////// INICIO --------- COMPETÊNCIA

$linha_competencia = $_POST["linha_competencia"];
$sinal_competencia = $_POST["sinal_competencia"];

$cl_princ_competencia = $_POST["cl_princ_competencia"];
$cl_princ_sinal_competencia = $_POST["cl_princ_sinal_competencia"];

$cl_seg_competencia = $_POST["cl_seg_competencia"];
$cl_seg_sinal_competencia = $_POST["cl_seg_sinal_competencia"];

$nome_tabela = "$linha_competencia$cl_seg_competencia$cl_princ_competencia";

$sinal = "$sinal_competencia $cl_princ_sinal_competencia $cl_seg_sinal_competencia";

if(substr_count($sinal, "-") == 3){
	$valor_competencia = "1";
}
	
if(substr_count($sinal, "-") == 2){
	$valor_competencia = "1";
}
		
if((substr_count($sinal, "0") == 2) and (substr_count($sinal, "-") == 1)){
	$valor_competencia = "2";
}	

if((substr_count($sinal, "0") == 1) and (substr_count($sinal, "-") == 1) and (substr_count($sinal, "+") == 1)){
	$valor_competencia = "2";
}

if(substr_count($sinal, "0") == 3){
	$valor_competencia = "2";
}



if((substr_count($sinal, "+") == 2) and (substr_count($sinal, "0") == 1)){
	$valor_competencia = "3";
}	

if((substr_count($sinal, "+") == 1) and (substr_count($sinal, "0") == 2)){
	$valor_competencia = "3";
}	


if(substr_count($sinal, "+") == 3){
	$valor_competencia = "3";
}	

if((substr_count($sinal, "+") == 2) and (substr_count($sinal, "-") == 1)){
	$valor_competencia = "3";
}	
	
$nome_tabela .= $valor_competencia;

$select_valor = "SELECT $nome_tabela FROM capacidade_gerencial WHERE $nome_tabela is not null";
$result_valor = mysql_query($select_valor);
$linha_valor = mysql_fetch_assoc($result_valor);
$valor_total_competencia = $linha_valor[$nome_tabela];


////////// FIM ----------- COMPETÊNCIA





/////////// INICIO ---------  CAPACIDADE DECISORIA

$linha_capacidade_decisoria = $_POST["linha_capacidade_decisoria"];
$simbolo_capacidade_decisoria1 = $_POST["simbolo_capacidade_decisoria1"];

$coluna_capacidade_decisoria = $_POST["coluna_capacidade_decisoria"];
$simbolo_capacidade_decisoria2 = $_POST["simbolo_capacidade_decisoria2"];


$campo_capacidade = "$linha_capacidade_decisoria$coluna_capacidade_decisoria";

$sinal_capacidade_decisoria = "$simbolo_capacidade_decisoria1 $simbolo_capacidade_decisoria2";

if(substr_count($sinal_capacidade_decisoria, "0") == 2){
	$valor_capacidade = "1";
}
	
if(substr_count($sinal_capacidade_decisoria, "+") == 2){
	$valor_capacidade = "2";
}
		
if((substr_count($sinal_capacidade_decisoria, "0") == 1) and (substr_count($sinal_capacidade_decisoria, "+") == 1)){
	$valor_capacidade = "2";
}	

	
$campo_capacidade .= $valor_capacidade;

$select_capacidade = "SELECT $campo_capacidade FROM complexidade";

$result_capacidade = mysql_query($select_capacidade);
$linha_capacidade = mysql_fetch_assoc($result_capacidade);
$valor_porcento_capacidade = $linha_capacidade[$campo_capacidade];
$valor_total_capacidade = (($valor_porcento_capacidade*$valor_total_competencia)/100);


////////// FIM ----------- CAPACIDADE DECISORIA







/////////// INICIO ---------  CAPACIDADE DECISORIA

$linha_resultados_finais = $_POST["linha_resultados_finais"];
$simbolo_resultados_finais1 = $_POST["simbolo_resultados_finais1"];

$coluna_resultados_finais_principal = $_POST["coluna_resultados_finais_principal"];
$simbolo_resultados_finais2 = $_POST["simbolo_resultados_finais2"];

$coluna_resultados_finais_secundaria = $_POST["coluna_resultados_finais_secundaria"];
$simbolo_resultados_finais3 = $_POST["simbolo_resultados_finais3"];


$campo_resultados = "$linha_resultados_finais$coluna_resultados_finais_secundaria$coluna_resultados_finais_principal";

$sinal_resultados = "$simbolo_resultados_finais1 $simbolo_resultados_finais2 $simbolo_resultados_finais3";
	

if(substr_count($sinal_resultados, "-") == 3){
	$valor_resultados = "1";
}
	
if(substr_count($sinal_resultados, "-") == 2){
	$valor_resultados = "1";
}
		
if((substr_count($sinal_resultados, "0") == 2) and (substr_count($sinal_resultados, "-") == 1)){
	$valor_resultados = "2";
}	

if((substr_count($sinal_resultados, "0") == 1) and (substr_count($sinal_resultados, "-") == 1) and (substr_count($sinal_resultados, "+") == 1)){
	$valor_resultados = "2";
}

if(substr_count($sinal_resultados, "0") == 3){
	$valor_resultados = "2";
}



if((substr_count($sinal_resultados, "+") == 2) and (substr_count($sinal_resultados, "0") == 1)){
	$valor_resultados = "3";
}	

if((substr_count($sinal_resultados, "+") == 1) and (substr_count($sinal_resultados, "0") == 2)){
	$valor_resultados = "3";
}	


if(substr_count($sinal_resultados, "+") == 3){
	$valor_resultados = "3";
}	

if((substr_count($sinal_resultados, "+") == 2) and (substr_count($sinal_resultados, "-") == 1)){
	$valor_resultados = "3";
}


$campo_resultados .= $valor_resultados;

$select_resultados = "SELECT $campo_resultados FROM resultados_funcionais";
$result_resultados = mysql_query($select_resultados);
$linha_resultados = mysql_fetch_assoc($result_resultados);
$valor_total_resultados = $linha_resultados[$campo_resultados];



////////// FIM ----------- CAPACIDADE DECISORIA







/////////// INICIO ---------  CONDICOES DE TRABALHO

$linha_condicoes_trabalho = $_POST["linha_condicoes_trabalho"];

$simbolo_condicoes_trabalho1 = $_POST["simbolo_condicoes_trabalho1"];

$coluna_condicoes_trabalho_principal = $_POST["coluna_condicoes_trabalho_principal"];
$simbolo_condicoes_trabalho2 = $_POST["simbolo_condicoes_trabalho2"];

$coluna_condicoes_trabalho_secundaria = $_POST["coluna_condicoes_trabalho_secundaria"];
$simbolo_condicoes_trabalho3 = $_POST["simbolo_condicoes_trabalho3"];


$campo_condicoes_trabalho = "$linha_condicoes_trabalho$coluna_condicoes_trabalho_secundaria$coluna_condicoes_trabalho_principal";

$sinal_condicoes_trabalho = "$simbolo_condicoes_trabalho1 $simbolo_condicoes_trabalho2 $simbolo_condicoes_trabalho3";
	
if(substr_count($sinal_condicoes_trabalho, "-") == 3){
	$valor_condicoes_trabalho = "1";
}
	
if(substr_count($sinal_condicoes_trabalho, "-") == 2){
	$valor_condicoes_trabalho = "1";
}
		
if((substr_count($sinal_condicoes_trabalho, "0") == 2) and (substr_count($sinal_condicoes_trabalho, "-") == 1)){
	$valor_condicoes_trabalho = "2";
}	

if((substr_count($sinal_condicoes_trabalho, "0") == 1) and (substr_count($sinal_condicoes_trabalho, "-") == 1) and (substr_count($sinal_condicoes_trabalho, "+") == 1)){
	$valor_condicoes_trabalho = "2";
}

if(substr_count($sinal_condicoes_trabalho, "0") == 3){
	$valor_condicoes_trabalho = "2";
}



if((substr_count($sinal_condicoes_trabalho, "+") == 2) and (substr_count($sinal_condicoes_trabalho, "0") == 1)){
	$valor_condicoes_trabalho = "3";
}	

if((substr_count($sinal_condicoes_trabalho, "+") == 1) and (substr_count($sinal_condicoes_trabalho, "0") == 2)){
	$valor_condicoes_trabalho = "3";
}	


if(substr_count($sinal_condicoes_trabalho, "+") == 3){
	$valor_condicoes_trabalho = "3";
}	

if((substr_count($sinal_condicoes_trabalho, "+") == 2) and (substr_count($sinal_condicoes_trabalho, "-") == 1)){
	$valor_condicoes_trabalho = "3";
}

$campo_condicoes_trabalho .= $valor_condicoes_trabalho;

$select_condicoes_trabalho = "SELECT $campo_condicoes_trabalho FROM meio_ambiente";
//echo $select_condicoes_trabalho;
$result_condicoes_trabalho = mysql_query($select_condicoes_trabalho);
$linha_condicoes_trabalho = mysql_fetch_assoc($result_condicoes_trabalho);
$valor_total_condicoes_trabalho = $linha_condicoes_trabalho[$campo_condicoes_trabalho];



////////// FIM ----------- CONDICOES DE TRABALHO



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

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
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">ORGANIZAÇÃO</td>
						<td align="center">CARGO</td>
						<td align="center" colspan="4">COMPETÊNCIA</td>
						<td align="center" colspan="4">CAPACIDADE DECISÓRIA</td>
						<td align="center" colspan="4">RESULTADOS FUNCIONAIS</td>
						<td align="center" colspan="4">CONDIÇÕES DE TRABALHO</td>
						<td align="center" colspan="4">TOTAL PONTOS</td>
					</tr>
							
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" >
						<?=$orga_nome?>
						<!--  -->
						<input type="hidden" value="<?=$cargo?>" name="orga">
						</td>
						
						<td align="center" ><?=$cargo_nome?></td>
						
						<td align="center">
							<?
							echo $linha_competencia." ".$sinal_competencia;
							$linha_competencia_salvar = $linha_competencia." ".$sinal_competencia;
							
							?>
							<input type="hidden" value="<?=$linha_competencia_salvar?>" name="linha_competencia_salvar">
						</td>
						
						<td align="center" style="text-transform:uppercase;">
							<?
								echo $cl_princ_competencia." ".$cl_princ_sinal_competencia;						
								$cl_princ_competencia_salvar = $cl_princ_competencia." ".$cl_princ_sinal_competencia;	
							
							?>
							<input type="hidden" value="<?=$cl_princ_competencia_salvar?>" name="cl_princ_competencia_salvar">
						</td>
						
						<td align="center">
						
							<?
								echo $cl_seg_competencia." ".$cl_seg_sinal_competencia;
								$cl_seg_competencia_salvar =  $cl_seg_competencia." ".$cl_seg_sinal_competencia;	
							
							?>
							<input type="hidden" value="<?=$cl_seg_competencia_salvar?>" name="cl_seg_competencia_salvar">
							
						</td>
						
						<td align="center"><? echo $valor_total_competencia;?></td>
						
						
						<!-- CAPACIDADE DECISORIA -->
						<td align="center">
							<?
							echo $linha_capacidade_decisoria." ".$simbolo_capacidade_decisoria1;
							$linha_capacidade_decisoria_salvar = $linha_capacidade_decisoria." ".$simbolo_capacidade_decisoria1;
							
							?>
							<input type="hidden" value="<?=$linha_capacidade_decisoria_salvar?>" name="linha_capacidade_decisoria_salvar">
						
						</td>
						<td align="center" style="text-transform:uppercase;">
							<?
								echo $coluna_capacidade_decisoria." ".$simbolo_capacidade_decisoria2;
								$coluna_capacidade_decisoria_salvar = $coluna_capacidade_decisoria." ".$simbolo_capacidade_decisoria2;
							
							?>
							<input type="hidden" value="<?=$coluna_capacidade_decisoria_salvar?>" name="coluna_capacidade_decisoria_salvar">
						
						</td>
						<td align="center">
						
								<?=$valor_porcento_capacidade?> %
								<input type="hidden" value="<?=$valor_porcento_capacidade?>" name="valor_porcento_capacidade">
											
						</td>
						<td align="center">
								<?
								
							$valor_total_capacidade2 = number_format($valor_total_capacidade,0); 
							echo $valor_total_capacidade2;
								
								?> 
								<input type="hidden" value="<?=$valor_total_capacidade2?>" name="valor_total_capacidade">	
						
						</td>
						<!-- CAPACIDADE DECISORIA -->
						
						
						
						<!-- RESULTADOS FUNCIONAIS -->
						<td align="center">	
							<?
							echo $linha_resultados_finais." ".$simbolo_resultados_finais1;
							$linha_resultados_finais_salvar = $linha_resultados_finais." ".$simbolo_resultados_finais1;
							
							?>
							<input type="hidden" value="<?=$linha_resultados_finais_salvar?>" name="linha_resultados_finais_salvar">
							
						</td>
						<td align="center" style="text-transform:uppercase;">
							<?
							echo $coluna_resultados_finais_principal." ".$simbolo_resultados_finais2;
							$coluna_resultados_finais_principal_salvar = $coluna_resultados_finais_principal." ".$simbolo_resultados_finais2;
							
							?>
							<input type="hidden" value="<?=$coluna_resultados_finais_principal_salvar?>" name="coluna_resultados_finais_principal_salvar">
							
						</td>
						<td align="center" style="text-transform:uppercase;">
							<?
							echo $coluna_resultados_finais_secundaria." ".$simbolo_resultados_finais3;
							$coluna_resultados_finais_secundaria_salvar = $coluna_resultados_finais_secundaria." ".$simbolo_resultados_finais3;
							
							?>
							<input type="hidden" value="<?=$coluna_resultados_finais_secundaria_salvar?>" name="coluna_resultados_finais_secundaria_salvar">
						</td>
						<td align="center"><?=$valor_total_resultados?></td>
						<!-- RESULTADOS FUNCIONAIS -->
						
						
						
						<!-- RESULTADOS CONDIÇÕES DE TRABALHO -->
						
					<td align="center" style="text-transform:uppercase;">	
							<?
							$linha_condicoes_trabalho2 = $_POST["linha_condicoes_trabalho"];
							echo $linha_condicoes_trabalho2." ".$simbolo_condicoes_trabalho1;
							$linha_condicoes_trabalho_salvar = $linha_condicoes_trabalho." ".$simbolo_condicoes_trabalho1;
							
							?>
							<input type="hidden" value="<?=$linha_condicoes_trabalho_salvar?>" name="linha_condicoes_trabalho_salvar">
							
						</td>
						<td align="center" style="text-transform:uppercase;">
							<?
							echo $coluna_condicoes_trabalho_principal." ".$simbolo_condicoes_trabalho2;
							$coluna_condicoes_trabalho_principal_salvar = $coluna_condicoes_trabalho_principal." ".$simbolo_condicoes_trabalho2;
							
							?>
							<input type="hidden" value="<?=$coluna_condicoes_trabalho_principal_salvar?>" name="coluna_condicoes_trabalho_principal_salvar">
							
						</td>
						<td align="center" style="text-transform:uppercase;">
							<?
							echo $coluna_condicoes_trabalho_secundaria." ".$simbolo_condicoes_trabalho3;
							$coluna_condicoes_trabalho_secundaria_salvar = $coluna_condicoes_trabalho_secundaria." ".$simbolo_condicoes_trabalho3;
							
							?>
							<input type="hidden" value="<?=$coluna_condicoes_trabalho_secundaria_salvar?>" name="coluna_condicoes_trabalho_secundaria_salvar">
						</td>
						<td align="center"><?=$valor_total_condicoes_trabalho?></td>
						
						<!-- RESULTADOS CONDIÇÕES DE TRABALHO -->
						<td align="center">
							<?
							$valor_total = $valor_total_condicoes_trabalho + $valor_total_resultados + $valor_total_competencia + $valor_total_capacidade2;
							echo $valor_total; 
							?>
							
						</td>
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
</html>