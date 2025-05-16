<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
$sql_orga = " SELECT organizacao FROM ce_usuario WHERE CodUsuario=".$_SESSION["id_usuario_adm"];
$result_orga = mysql_query($sql_orga);
$linha_orga = mysql_fetch_assoc($result_orga);
$orga_id = $linha_orga["organizacao"];
$_SESSION["$orga_id"] = "$orga_id";
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<link rel="stylesheet" type="text/css" href="css/shadowbox.css">

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
				<img src="imagens/barra_tickets.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Ticket</td>
						<td align="center">Tipo do Ticket</td>
						<td align="center">Organização</td>
							<? 
							//$permissao = $_SESSION["per_adm"];
						//	if($permissao == "9999"){?>
						<td align="center"  width="1%" nowrap="nowrap">A&ccedil;&otilde;es</td>
						<?//}?>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM gerador_tickets WHERE ticket_unico != 0 and organizacao='$orga_id'  ORDER BY id desc";
				$result = mysql_query($sql) or die(mysql_error());
				
				while($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["numero_ticket"]?> </td>	
						<td align="center" ><?=$linha["tipo_ticket"]?> </td>						
					    <td align="center" >
                        <?php
                        $org = mysql_query("SELECT * FROM organizacoes WHERE id = '".$linha["organizacao"]."'");
                        $org = mysql_fetch_array($org);
                        echo $org["nome"];
                        ?> 
                        
                        </td>		
                        
                        <td align="center" width="1%" nowrap="nowrap" >
                        
                        	<a rel="shadowbox[Mixed]width=600;height=170" href="ticket_unico_envia.php?id=<?=$linha["id"]?>"  title="Enviar Ticket por E-mail">
                        		<img src="imagens/icon_sendmail.png" border="0" title="Enviar Ticket por E-mail" alt="Enviar Ticket por E-mail"  />
                        	</a>
                        
                        	<a href="?apagar=1&cod=<?=$linha["id"]?>">
                        		<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o ticket único?')" alt="Apagar" border="0">
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
			
			
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="js/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>
</html>