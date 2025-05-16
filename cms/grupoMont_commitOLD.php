<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
//echo phpinfo();
if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM aplicacoes_commit WHERE id=".$_REQUEST['cod'];
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
	
			
			<form action="grupoMont_commit.php" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">

				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome:</span> </div>

						<input class="form_style" type="text" size="50" name="nome">
				      
				</div>	
				

				<p align="center"><input type="submit" value="Localizar" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>	
			
			<form action="grupoMont_commit2.php" method="POST">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
				<p align="center">
						O gráfico deve ser gerado por página.
					</p>
			
					<p align="center"><input type="submit" value="Gerar Grafico" class="form_style" name="localizar"></p>
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Tempo</td>
						<td align="center">Ticket</td>
						<td align="center">Empresa</td>
						<td align="center">Cargo</td>
						<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444")){?>
						<td align="center">A&ccedil;&otilde;es</td>
						<?}?>
					</tr>
				
					
			<?
				/*//$sql = "SELECT *, date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`  FROM aplicacoes ORDER BY nome";
				$sql = "
				SELECT
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.cargo,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
				aplicacoes_commit.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes_commit.grupo = grupos.id
				left Join organizacoes ON aplicacoes_commit.organizacao = organizacoes.id
				ORDER BY aplicacoes_commit.data_aplic desc
				"
				;
				$result = mysql_query($sql);*/
				$where = " ";
				$aplicacaoINNER = " ";
				$campoINNER = " ";
					
					if($_POST["nome"] != ""){
					$nome_pesq = $_POST["nome"];
						$where = " WHERE aplicacoes_commit.nome like '%$nome_pesq%'";
				}
				
				
				
				$sql = "SELECT
				$campoINNER
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.cargo,
				aplicacoes_commit.ticket,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				aplicacoes_commit.status_envio
				FROM
				aplicacoes_commit
				$aplicacaoINNER
				 $where ORDER BY aplicacoes_commit.data_aplic desc
				LIMIT $inicial, $numreg";
				$result = mysql_query($sql);
				$i = $inicial;
				
				$sql2 = "SELECT
				$campoINNER
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.ticket,
				aplicacoes_commit.cargo,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,				
				aplicacoes_commit.status_envio
				FROM
				aplicacoes_commit
				$aplicacaoINNER
				 $where ORDER BY aplicacoes_commit.data_aplic desc
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
				//echo $linha["respostas"];
				
			?>				
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
						<td align="center" ><?=$linha["databr"]?></td>
						<td align="left" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["tempo"]?> </td>
						<td align="center" ><?=$linha["ticket"]?> </td>
						<td align="center" >
						<?	
							if($organizacaon){
								echo $linha["nome_cliente"];	
							}else{
								$tik =$linha["ticket"];
								$sql_empresa="SELECT
								gerador_tickets_pedidos.nome_cliente,
								gerador_tickets.numero_ticket
								FROM
								gerador_tickets_pedidos
								Inner Join gerador_tickets ON gerador_tickets.num_pedido = gerador_tickets_pedidos.id
								WHERE
								gerador_tickets.numero_ticket =".$linha["ticket"];
								$result_empresa = mysql_query($sql_empresa);
								$linha_empresa = mysql_fetch_assoc($result_empresa);
								
								echo $linha_empresa["nome_cliente"];
							}
						?>
						</td>
						<td align="center" ><?=$linha["cargo"]?> </td>
	<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444")){?>
						<td align="center" width="1%" nowrap>
						
						<input type="checkbox" value="<?=$linha["id"]?>" name="gerar[]">
						
						</td>
	<?}?>
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
			</form>
				
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