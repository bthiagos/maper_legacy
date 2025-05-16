<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
//echo phpinfo();

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM aplicacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao
//echo date("d/m/Y H:i:s");
?>

<?php				$where = "";
					//######### INICIO Paginação
				
					    $numreg = 50; // Quantos registros por página vai ser mostrado
					  if (!isset($pg)) {
					       $pg = 0;
					    }
					   $pg = $_REQUEST["pg"];
					    $inicial = $pg * $numreg;
					   
					//######### FIM dados Paginação
					
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<style type="text/css">

.pgoff {font-family: Aril, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a.pg {font-family: Arial, Arial, Helvetica; font-size:11px; color: #666666; text-decoration: none}
.pg{font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:hover.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:visited.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
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
				<img src="imagens/barra_avaliacao_realizadas.gif" alt="Avaliações Realizadas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="aplica_gerencia2.php" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">

				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome:</span> </div>

						<input class="form_style" type="text" size="50" name="nome">
				      
				</div>	
				
				
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização:</span> </div>
					
						
						<?
				          $sql = "SELECT * FROM `organizacoes` ORDER BY `nome`";
				          $result = mysql_query($sql);
				          //echo $result;
				          ?>
				          <select name="orga" style="width:200px;">
				          <option value="" selected="selected">Selecione</option>
				
				          <? while ($linha = mysql_fetch_assoc($result)) { 
				          	$id = $_POST["orga"];
				          	if($linha["id"] == $id){
				          		$select = " SELECTED ";
				          	}else{
				          		$select = " ";
				          	}
				          	
				          	?>
				          	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
					         <? }?>
        			</select>
				</div>	

				<p align="center"><input type="submit" value="Localizar" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>	
			
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Tempo</td>
						<td align="center">Organização</td>
						<td align="center">Grupo</td>
						<td align="center">Cargo</td>
						<td align="center">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				/*//$sql = "SELECT *, date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`  FROM aplicacoes ORDER BY nome";
				$sql = "
				SELECT
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id
				ORDER BY aplicacoes.data_aplic desc
				"
				;
				$result = mysql_query($sql);*/
				$where = " ";
				
				
					if ($_REQUEST["orga"] != ""){
						$id_orga = $_REQUEST["orga"];
					
						$where = "WHERE organizacoes.id = $id_orga";
					}else{
				
						if ($_POST["orga"] != ""){
							$id_orga = $_POST["orga"];
							
							$where = "WHERE organizacoes.id = $id_orga";
						
						}
					}	
				
				if($_POST["nome"] != ""){
					$nome_pesq = $_POST["nome"];
					if($where != "WHERE organizacoes.id = $id_orga" ){
						$where .= "WHERE aplicacoes.nome like '%$nome_pesq%'";
					}else{
						$where .= " and aplicacoes.nome like '%$nome_pesq%'";
					}
				}
				
				
				$sql = "SELECT
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic desc
				LIMIT $inicial, $numreg";
				$result = mysql_query($sql);
				$i = $inicial;
				
				$sql2 = "SELECT
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic desc
				";
				$result2 = mysql_query($sql2);
				
				$quantreg = mysql_num_rows($result2);
			  	$quant_pg = ceil($quantreg/$numreg);
				$quant_pg++;
				
				if($quantreg == 0){
					echo "<span class=\"label_fonte\">Nenhum registro</span>";
				}
				
				//echo $sql2;
				while ($linha = mysql_fetch_assoc($result)) {
				$i++;
				$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta.php?id=".$linha["id"];
				$nome_session = "url_".$linha["id"];
				//$resultado_url = executa_url($url);
				//$_SESSION["$nome_session"] = $resultado_url;
				//echo $_SESSION[$nome_session];
				
			?>				
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
						<td align="center" ><?=$linha["databr"]?></td>
						<td align="left" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["tempo"]?> </td>
						<td align="center" ><?=$linha["orga"]?> </td>
						<td align="center" >
						<?
								echo $linha["grupo"];
							
						?>
						</td>
						<td align="center" ><?=$linha["cargo"]?> </td>

						<td align="center" width="1%" nowrap>
							
						
							<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/sim.gif" title="Gerar PDF Para Venda" alt="Gerar PDF Para Venda" border="0"></a> 
						
							<!-- Icone de edicao -->
							<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>" target="_blank">
								<img src="imagens/icon_sorteio.gif" title="Gerar Laudo" alt="Gerar Laudo" border="0">
							</a>

							<!--<a href="testepdf.php?id=<?php echo $linha["id"];?>"&orga=<?=$linha["id_orga"]?>><img src="imagens/icon_email.gif" title="Enviar E-mail" alt="Enviar E-mail" border="0"></a>-->
							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Gerar PDF Completo" alt="Gerar PDF Completo" border="0"></a> 
           							  
							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Gerar PDF 2 Paginas" alt="Gerar PDF 2 Paginas" border="0"></a> 
							
							<a href="aplica_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							<a href="aplica_gerencia.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a avaliação de <?=$linha["nome"]?> ?')" title="Apagar" alt="Apagar" border="0"></a></td>
					</tr>
				
				<?
				}
				?>
				
					<tr>
					<td align="center" colspan="8">
				 <?   // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
				    if ( $pg > 0) {
				        echo "<a href=".$PHP_SELF."?pg=".($pg-1)."&orga=$id_orga  class=pg><b>&laquo; anterior</b></a>";
				    } else {
				        echo "<span class=pg><b>&laquo; anterior</b></span>";
				    }
				     for($i_pg=1;$i_pg<$quant_pg;$i_pg++) {
				        // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente
				        if ($pg == ($i_pg-1)) {
				            echo "&nbsp;<span class=pg>[$i_pg]</span>&nbsp;";
				        } else {
				            $i_pg2 = $i_pg-1;
				            echo "&nbsp;<a href=".$PHP_SELF."?pg=$i_pg2&orga=$id_orga class=pg><b>$i_pg</b></a>&nbsp;";
				        }
				    }
				    
				    // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
				    if (($pg+2) < $quant_pg) {
				        echo "<a href=".$PHP_SELF."?pg=".($pg+1)."&orga=$id_orga class=\"pg\"><b>próximo &raquo;</b></a>";
				    } else {
				        echo "<span class=pg>próximo &raquo;</span>";
				    }
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