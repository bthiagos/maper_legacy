<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
//echo phpinfo();
if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}


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
			
			<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Grupos:</span> </div>				
						
					<?
						if($organizacaon){					
							if($where!=""){
								$where .= " and gerador_tickets_pedidos.nome_cliente='$organizacaon'";
							}else{
								$where = " WHERE gerador_tickets_pedidos.nome_cliente='$organizacaon'";
							}
						}
				
			         	 $sql=  "SELECT nome_cliente
								FROM gerador_tickets_pedidos $where ORDER BY `nome_cliente`";
			         	 $result = mysql_query($sql);	          
			        
			          ?>
			          <select name="orga[]" multiple size="10" class="form_style" style="width:400px;">
			                 <? while ($linha = mysql_fetch_assoc($result)) { ?>
			                  		<option value="<?=$linha["nome_cliente"]?>" <?=$select?> ><?=$linha["nome_cliente"]?></option>
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
			
			
			<? 
			
			
			if($_POST["orga"]){
				
				$id_orga = $_POST["orga"];			
				$where = "";
				
				for($i=0;$i<count($id_orga);$i++){
					if($where==""){
						$where = " WHERE gerador_tickets_pedidos.nome_cliente='". $id_orga[$i]."'";
					}else{
						$where .= " OR gerador_tickets_pedidos.nome_cliente='". $id_orga[$i]."'";
					}	
				}			
			
			?>
			
			<form action="grupoMont_commit2.php" method="POST" target="_blank">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
				
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Tempo</td>
						<td align="center">Ticket</td>
						<td align="center">Empresa</td>
						<td align="center">Cargo</td>
						<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555")){?>
						<td align="center">A&ccedil;&otilde;es</td>
						<?}?>
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
				
					
				if($organizacaon){
					$where = " ";					
					if($where!=""){
						$where .= " and gerador_tickets_pedidos.nome_cliente='$organizacaon'";
					}else{
						$where = " WHERE gerador_tickets_pedidos.nome_cliente='$organizacaon'";
					}
				}
				
				
				
				$sql = "SELECT
			gerador_tickets_pedidos.nome_cliente,
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
				INNER JOIN gerador_tickets ON aplicacoes_commit.ticket = gerador_tickets.numero_ticket INNER JOIN gerador_tickets_pedidos ON gerador_tickets.num_pedido = gerador_tickets_pedidos.id
				 $where ORDER BY aplicacoes_commit.data_aplic desc";
				
				$result = mysql_query($sql);
				//echo $sql;
				$i=0;
				while ($linha = mysql_fetch_assoc($result)) {
				$i++;
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
	<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555")){?>
						<td align="center" width="1%" nowrap>
							
							<input type="checkbox" value="<?=$linha["id"]?>" name="gerar[]">
						
						</td>
	<?}?>
					</tr>
				
				<?
				}
				?>
				
				
					</table>
					
					<input type="hidden" value="<?=$where?>" name="awhere">
 					<p align="center">
 						<input type="submit" value="Gerar Grafico Pessoas Selecionadas" class="form_style" name="pessoas"> &nbsp;
 						<input type="submit" value="Gerar Grafico de Todos Listados" class="form_style" name="grupos">
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