<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {		

				$sql = "DELETE FROM pedidos WHERE id=".$_REQUEST['cod'];
				if (mysql_query($sql)) {
					alert("Excluido com sucesso!");
				}
	
}
// --- FIM    Efetuando a exlcusao


if ($_REQUEST["tickets"]) {
	
	$id = $_REQUEST["cod"];
	
	$sql = "
		SELECT
		*
		FROM
		pedidos
		WHERE
		id=$id
	";
	
	//echo $sql;
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$quant = $linha["quant"];
	$num_pedido = $linha["num_pedido"];
	$nome = $linha["nome"];
	$email = $linha["email"];

	
	for ($i=0;$i<$quant;$i++) {
		$ticket = time().$i;
		$sql = "INSERT INTO tickets (num_ticket,num_pedido,status) VALUES ('$ticket','$num_pedido','0')";
		mysql_query($sql);
	}
	
	$sql = "UPDATE pedidos SET gera=1 WHERE id=$id";
	if (mysql_query($sql)) {
		alert("Foram gerados $quant tickets!");
		dispara_email_tickets($num_pedido,$email,$nome);
		redireciona("tickets_gerencia.php?num_pedido=$num_pedido");
	}
	
	
	
}

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
				<img src="imagens/barra_pedidos_gerencia.gif" alt="Gerenciamento de pedidos" title="Gerenciamento de pedidos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Pedido</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Sexo</td>
						<td align="center">CPF</td>
						<td align="center">E-mail</td>
						<td align="center">Quantidade</td>
						<td align="center">Status</td>
						<td align="center">Tickets Gerados?</td>
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "
					SELECT
					pedidos.id,
					pedidos.id_transa,
					pedidos.data_transa,
					pedidos.nome,
					pedidos.sexo,
					pedidos.email,
					pedidos.cpf,
					pedidos.quant,
					pedidos.gera,
					pedidos.num_pedido,
					status_pedido.nome_status
					FROM
					pedidos
					Inner Join status_pedido ON pedidos.status_pag = status_pedido.status_locaweb
					ORDER BY
					num_pedido DESC
				";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					$data = $linha["data"];
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" width="1%" nowrap><?=$linha["num_pedido"]?></td>
						<td align="center" ><?=$linha["data_transa"]?></td>
						<td align="center" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["sexo"]?></td>
						<td align="center" ><?=$linha["cpf"]?></td>
						<td align="center" ><?=$linha["email"]?></td>
						<td align="center" ><?=$linha["quant"]?></td>
						<td align="center" ><?=$linha["nome_status"]?></td>
						<td align="center" >
						
						<?
						if ($linha["gera"] == 1) {
							echo "Sim";
						} else {
							echo "Não";
						}
						
						?>
						
						</td>
						<td align="center" width="1%" nowrap>
						<!---->
						<? if ($linha["gera"] != 1) { ?>
						<a href="pedidos_gerencia.php?tickets=1&cod=<?=$linha["id"]?>">Gerar Tickets</a> 
						<? } else { ?>
						<a href="tickets_gerencia.php?num_pedido=<?=$linha["num_pedido"]?>">Ver Tickets</a> 
						<? } ?>
						
						<a href="pedidos_alt.php?edit=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a> 
						
						<a href="pedidos_gerencia.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir ?')" alt="Apagar" border="0"></a></td>
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
			
			
			
			
			
			
			
					
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>