<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

            /*
                $array = "6566,7789,10860,6527,5293,9261,8222,9390,6740,7478,5537,8234,6792,8599,7131,7828,9515,7833,5227,7484,6532,5161,8374,8984,5342,7624,5198,6528,7521,7508,6534,8610,7271,7317,10851,5230,8316,7443,8352,7435,8981,8227,7253,7825,6535,5137,8619,7714,8693,5228,6830,8887,9626,10850,5123,5116,7434,6931,5489,7830,9186,5256,7313,7643,5347,7813,8657,6939,5184,7129,6565,6853,6525,5177,7130,5235,5340,7438,7530,8622,5158,6838,6557,8232,5182,9264,6816,7522,5295,5236,7441,7635,10814,6524,7703,5131";
                $array_ex = explode(",",$array);
                $array = str_replace(",","' OR aplicacoes.id = '",$array);
                $array .= "')";
              */  

                
				
//echo __FILE__;

//echo phpinfo();

if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}
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
				
					    $numreg = 110; // Quantos registros por página vai ser mostrado
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
			
			<form action="perfil_cargos_grupos.php" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<? if(($permissao == "99991") or ($permissao == "99992")){ ?>
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização:</span> </div>
					
						
						<?
						
				          $sql = "SELECT * FROM `organizacoes` $whereorga ORDER BY `nome`";
				          $result = mysql_query($sql);
				          //echo $result;
				          ?>
				          <select name="orga2" onchange="submit();" class="form_style" style="width:200px;">
				          <option value="" selected="selected">Selecione</option>
				
				          <? while ($linha = mysql_fetch_assoc($result)) { 
				          	$id2 = $_POST["orga2"];
				          	if($linha["id"] == $id2){
				          		$select = " SELECTED ";
				          	}else{
				          		$select = " ";
				          	}
				          	
				          	?>
				          	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
					         <? }?>
        			</select>
			</div>	

			<?}?>
					
			<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Grupos:  <i>(Pressione CTRL para escolher varias opções)</i></span> </div>
					
						
						<?
						if($organizacaon){
							$whereorga = " WHERE id_organizacao='$organizacaon'";
						}
						if($id2){
							$whereorga = "WHERE id_organizacao='$id2'";
						}
					
				          $sql = "SELECT
									grupos.nome AS nomegrupo,
									grupos.id,
									grupos.id_organizacao,
									organizacoes.nome AS anomeorga
									FROM grupos INNER JOIN organizacoes ON grupos.id_organizacao = organizacoes.id
									 $whereorga ORDER BY `anomeorga`";
				          $result = mysql_query($sql);
				          
				         // echo $sql;
				          ?>
				          <select name="orga[]" multiple size="10" class="form_style" style="width:400px;">
				
				          <? while ($linha = mysql_fetch_assoc($result)) { 
				          
				          	
				          	?>
				          	<option value="<?=$linha["id"]?>/<?=$linha["id_organizacao"]?>" <?=$select?> ><?=$linha["anomeorga"]?> - <?=$linha["nomegrupo"]?></option>
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
			
			
			<? if($_POST["orga"] != "" ){?>
			<form action="perfil_cargos_grupos_pesos.php" target="_blank"  method="POST" >
			
			
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
					<tr height="30">						
						<td align="center" colspan="7">
					  		 TODOS
						</td>					
						<td align="center" width="1%" nowrap>
						<input type="checkbox" value="0" id="selectAll" name="opcao[]"/>
						</td>
					</tr>
										
			<?			
					
				$id_orga = $_POST["orga"];			
				$where = "";
				
				for($i=0;$i<count($id_orga);$i++){
				    $gp_og = explode("/",$id_orga[$i]);
                    $gp = $gp_og[0];
                    $og = $gp_og[1];
					if($where==""){
						$where = " WHERE (aplicacoes.grupo = '". $gp. "' and aplicacoes.organizacao = '$og')";
					}else{
						$where .= " or (aplicacoes.grupo = '". $gp. "' and aplicacoes.organizacao = '$og')";
					}	
				}
			
				if($organizacaon){
					if($where!=""){
						$where .= " and organizacoes.id='$organizacaon'";
					}else{
						$where = " WHERE organizacoes.id='$organizacaon'";
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
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.nome asc 
				";
				
                $result = mysql_query($sql);
				
				
				//echo $sql;
				$i=0;
				//break;
				while ($linha = mysql_fetch_assoc($result)) {
				$i++;
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
							<input type="checkbox" value="<?=$linha["id"]?>" name="aplicacoes[]">
						</td>
					</tr>
				
				<?
				}
                	
				?>
				
					
					</table>
                             
					<input type="hidden" value="<?=$where?>" name="awhere">
 					<p align="center">
 						<input type="submit" value="Visualizar Formulário" class="form_style" name="pessoas"> 
 					</p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
			</form>
				
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
</html>