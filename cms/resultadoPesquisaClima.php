<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM pesquisa_enviados WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		$frase = "Pesquisa excluido com sucesso!";
		alert($frase);
		 
	}
	
}

// --- FIM    Efetuando a exlcusao

?>

<?
if($_REQUEST["cadastra"]){
	
	if($_POST["tiporesp"] != ""){
		$tiporesp = $_POST["tiporesp"];
	}else{
		$tiporesp = "1";
	}
	
	if($_POST["dia_inicio"]){
		$dia2 = $_POST["dia_inicio"];
	}

	if($_POST["mes_inicio"]){
		$mes2 = $_POST["mes_inicio"];
	}
	
	if($_POST["ano_inicio"]){
		$ano2 = $_POST["ano_inicio"];
	}
	
	if(($ano2) and ($mes2) and ($dia2)){
		$data_envia = "$ano2-$mes2-$dia2";
		$where = "WHERE data_enviado='$data_envia' ";
	}
			
	
	
	if($_POST["pesquisa"]){
		$pesquisanome = $_POST["pesquisa"]."|".nome_pesquisa($_POST["pesquisa"]);
		if($data_envia){
			$where .= " AND codpesquisa = '$pesquisanome'";
		}else{
			$where = " WHERE codpesquisa = '$pesquisanome'";
		}
	}else{
		$pesquisanome = "";
	}
	
	if($_POST["grupo"]){
		$gruponome = $_POST["grupo"]."|".nome_grupo($_POST["grupo"]);
		if(($data) OR ($pesquisanome)){
			$where .= " AND codgrupo = '$gruponome'";
		}else{
			$where = " WHERE codgrupo = '$gruponome'";
		}
	}else{
			//$where ="";	
	}
}
?>


<?
// Buscando data para marcar o formulario
if (!$_POST["dia"]) {
	$dia = date("j");
} else {
	$dia = $_POST["dia"];
}

if (!$_POST["mes"]) {
	$mes = date("n");
} else {
	$mes = $_POST["mes"];
}

if (!$_POST["ano"]) {
	$ano = date("Y");
} else {
	$ano = $_POST["ano"];
}

if (!$_POST["hora"]) {
	$hora = date("H");
} else {
	$hora = $_POST["hora"];
}

if (!$_POST["minuto"]) {
	$minuto = date("i");
} else {
	$minuto = $_POST["minuto"];
}
?>
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
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<B>RESULTADO PESQUISA DE CLIMA</B>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="resultadoPesquisaClima.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form">
						<div id="label"> <span class="label_fonte">Por Data: </span> </div>
						<!-- Select de dia -->
						<select name="dia_inicio" class="form_style">
						<option value="">Dia</option>
						<?
							for ($i=1;$i<=31;$i++) {
								if ($dia2 == $i) {
									$check = "selected=\"selected\"";
								} else {
									$check = "";
								}
						?>
							<option value="<?=$i?>" <?=$check?>><?=$i?></option>
						<?
							}
						?>
						</select>
						<!-- Select de dia -->
						/
						<!-- Select de mes -->
						<select name="mes_inicio" class="form_style">
						<option value="">Mes</option>
						<?
							for ($i=1;$i<=12;$i++) {
								if ($mes2 == $i) {
									$check = "selected=\"selected\"";
								} else {
									$check = "";
								}
						?>
							<option value="<?=$i?>" <?=$check?>><?=ucfirst(string_mes($i));?></option>
						<?
							}
						?>
						</select>
						<!-- Select de mess -->
						/
						<!-- Select de ano -->
						<select name="ano_inicio" class="form_style">
						<option value="">Ano</option>
						<?
							for ($i=($ano-30);$i<=($ano+30);$i++) {
								if ($ano2 == $i) {
									$check = "selected=\"selected\"";
								} else {
									$check = "";
								}
						?>
							<option value="<?=$i?>" <?=$check?>><?=$i;?></option>
						<?
							}
						?>
						</select>
						<!-- Select de ano -->
												
					</div>
			
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Pesquisa: </span> </div>
					<select name="pesquisa" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM pesquisas ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								
							//$verifica =	verificar_pesquisas($linha["id"]);
							$verifica = 0;
							if($verifica != 1){
						?>						
						<option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
							<?}?>
						
						<?}?>
					</select>
				</div>
			
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo: </span> </div>
					<select name="grupo" class="form_style">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM clima_GrupoEmail ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
						?>
						
						<option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>
							
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Tipo do Resultado: </span> </div>
					<input type="radio" name="tiporesp" value="1"> <span class="label_fonte">Número </span> &nbsp;
					<input type="radio" name="tiporesp" value="2"> <span class="label_fonte">Percentual </span>
				</div>
				
				<p align="center"><input type="submit" value="Pesquisar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->			
			
				
			<? if($_REQUEST["cadastra"]) {
				
				
				?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<B>GERENCIAMENTO DO RESULTADO PESQUISA DE CLIMA</B>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" >Data</td>						
						<td align="center" >Grupo</td>						
						<td align="center" >Pesquisa</td>						
						<td align="center" >Numero de Respostas</td>						
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT *,date_format(data_enviado, '%d/%m/%Y') as data_formatada FROM pesquisa_enviados $where ORDER BY data_enviado";
				//echo $sql;
				$result = mysql_query($sql);
				$i=0;
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" width="3%"  ><?=$linha["data_formatada"]?></td>
						
						<td align="center" width="3%"  >
						
							<?	$explode_grupo = explode('|',$linha["codgrupo"]);
								$id_grupo = $explode_grupo[0];
								$sql_grupo = mysql_query("SELECT * FROM clima_GrupoEmail WHERE id=$id_grupo");
								$result_grupo = mysql_fetch_object($sql_grupo);
								//echo $result_grupo->nome;					
								echo $explode_grupo[1];					
							
							?>
						
						</td>
						<td align="center">
						
							<?	$explode_pesquisa = explode('|',$linha["codpesquisa"]);
								$id_pesquisa = $explode_pesquisa[0];
								$sql_pesquisa = mysql_query("SELECT * FROM pesquisas WHERE id=$id_pesquisa");
								$result_pesquisa = mysql_fetch_object($sql_pesquisa);
								echo $result_pesquisa->nome;					
							
							?>	
						
						</td>
						<td align="center" width="3%"><?=$linha["jarespondidos"];?></td>
						
						
						<td align="center" width="1%" nowrap>
							
						<? if($linha["jarespondidos"] != 0){ ?>
							<!-- Icone p/ Ver -->
							<a href="verPesquisaClimaBarra.php?cod=<?=$linha["id"]?>&tiporesp=<?=$tiporesp?>" target="_blank">
								<img src="imagens/icon_barra.png"  title="BARRA" alt="BARRA" border="0">
							</a>
							
							<!-- Icone p/ Ver -->
							<a href="verPesquisaClima.php?cod=<?=$linha["id"]?>&tiporesp=<?=$tiporesp?>" target="_blank">
									<img src="imagens/icon_pizza.PNG"  title="PIZZA" alt="PIZZA" border="0">
							</a>
						<?}?>	
                        
                        
							<!-- Icone de Exclusao -->
							<a href="resultadoPesquisaClima.php?apagar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir ?')" title="Apagar" alt="Apagar" border="0">
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
			
			
			
			<?}?>
			

			
			
			
			
				
				
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