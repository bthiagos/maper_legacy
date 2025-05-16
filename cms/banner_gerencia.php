<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM banner WHERE id=".$_REQUEST['id'];
	if (mysql_query($sql)) {
		alert("Banner excluido com sucesso!");
	}
	
}


// --- FIM    Efetuando a exlcusao

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
			
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
                        
                        
						
					    <td align="center">Foto</td>
                      
                        <td align="center">A&ccedil;&otilde;es</td>
                    </tr>
                      
                    			  
					
			<?
				$sql = "SELECT * FROM banner";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" 
                    onMouseOut="this.className='cel_fonte'">
						
                        
                        <form action="?or=<?=$linha["id"]?>" 
                        method="POST">
                                                
                        
                        <td align="center"><img src="uploaded/<?=$linha["foto"]?>"/> </td>
                      
                        </form>
                                                
                        </td>
					
						<td align="center" >
							<a href="banner_edita.php?edit=1&id=<?=$linha["id"]?>">
                            <img src="imagens/icon_editar.gif" alt="Editar" border="0"/></a>
							<a href="banner_gerencia.php?apagar=1&id=<?=$linha["id"]?>">
                            <img src="imagens/icon_apagar.gif" onclick="javascript: return confirm
                            ('Deseja realmente excluir o banner?')" alt="Apagar" border="0"/></a></td>
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