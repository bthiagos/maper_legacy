<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM gerador_tickets WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	

	//echo numeros;
		$cnpj = $_POST["cnpj"];
		$ok = 1;
		$numeros = mt_rand(1, 999999);
		$data = date("Y-m-d H:i:s");
		//echo $numeros;
		$c = 1;
		
		while($ok>0){
			
			$sql = "SELECT * FROM gerador_tickets WHERE numero_ticket = $numeros";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0){
				$numeros = mt_rand(1, 999999);
			}else{
				$sql_cadastra = "INSERT INTO gerador_tickets (cnpj,numero_ticket,data_gerado) VALUES('$cnpj','$numeros','$data')";
			
				mysql_query($sql_cadastra);
				$ok = 0;
			}
			
		}
}
// --- FIM    Efetuando o cadastro

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
			<div id="info">
				<img src="imagens/barra_gera_ticket.gif" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="gerar_tickets.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return valida_cpf_cnpj();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">CPF / CNPJ: </span> </div><input type="text" size="30" name="cnpj" value="<?=$cnpj;?>" class="form_style">
			
			</div>
			
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Numero do ticket &eacute; :</span></div>
				<b><?=$numeros?></b>
			</div>

				<p align="center"><input type="submit" value="Gerar Tickets" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_cadastro_uder.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Data</td>
						<td align="center">CPF / CNPJ</td>
						<td align="center">Numero do Ticket</td>
						<td align="center">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT *,date_format(data_gerado ,'%d/%m/%Y %H:%i:%s') AS `data1` FROM gerador_tickets ORDER BY data_gerado";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["data1"]?> </td>
						<td align="center" ><?=$linha["cnpj"]?> </td>
						<td align="center" ><?=$linha["numero_ticket"]?> </td>
						<td align="center" width="1%" nowrap>
							
							<a href="gerar_tickets.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o ticket ?')" alt="Apagar" border="0"></a></td>
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
			
			
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>