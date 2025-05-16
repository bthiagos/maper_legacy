<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

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
				<img src="imagens/barra_grupos_add.gif" alt="Cadastro de Grupos" title="Cadastro de Grupos" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="listagem_emails.php?envia=1" method="post" name="cadastra" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">

			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
				<select name="orga" class="form_style" onchange="submit();">
				<option value="Selecione">Selecione</option>
				<?
				
				if ($_POST["orga"]) {
					$orga = $_POST["orga"];
				} else {
					$orga = "";
				}
				
				$sql = "SELECT * FROM organizacoes ORDER BY nome";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($orga == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
			
			<? if ($orga != "") { ?>
				<? 
					if ($_POST["grupo"]) {
						$grupo= $_POST["grupo"];
					} else {
						$grupo = "";
					}
				?>
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Grupos: </span> </div>
				<select name="grupo" class="form_style">
				<option value="Selecione">Selecione</option>
				<?
				$sql = "SELECT * FROM grupos WHERE id_organizacao='$orga'";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					if ($grupo == $linha["id"]) {
						$select = "SELECTED";
					}else{
						$select = "";
					}
				?>
					<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				<?
					
					
					
				}
				
				?>
				</select>
			</div>
			<? } ?>
				
				
				
				
				<p align="center"><input type="submit" value="Cadastrar" name="teste" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->			
					
					
					
					
					
					
					
					
					
					
			
			<? if ($_POST["teste"] != "") { ?>
				<!-- INICIO - DIV info - Barra de informacao -->
				<div id="info">
				<img src="imagens/barra_grupos_gerencia.gif" alt="Gerenciamento de Grupos" title="Gerenciamento de Grupos" />
				</div>
				
				
				
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form" style="margin-bottom: 20px;">
				
				<div id="linha_form" style="overflow: hidden; height: auto;">
						<div id="label"> <span class="label_fonte">E-mails: </span> </div>
						
						<div style="border: 0px solid #000000; width: 80%; float: left; margin-bottom: 10px; font-family: Arial; font-size: 12px; color: #727272;">
						<?
						$sql2 = "SELECT * FROM aplicacoes WHERE organizacao='$orga' and grupo='$grupo' ORDER BY nome ASC";
						$result2 = mysql_query($sql2);
						
						
						while ($linha2 = mysql_fetch_assoc($result2)) {
		
							echo $linha2["email"]."; ";				
							
							
						}
						
						?>
						</div>
		
				</div>			
			</div>
				
				
				
				
				
		
		
		
					<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
					<div id="caixa_table">
			


				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Nome</td>
						<td align="center">E-mail</td>
					</tr>
				
					
			<?
				$sql = "
				SELECT * FROM aplicacoes WHERE organizacao='$orga' and grupo='$grupo' ORDER BY nome ASC
				";
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
					$i++;
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>			
		
				<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center"  width="1%" nowrap><?=$i?></td>

						<td align="center" >
						<?=$linha["nome"]?>
						</td>	
						
						<td align="center" >
						<?=$linha["email"]?>
						</td>	

				</tr>
				<?
				}
				?>
				</table>


			</div> <!-- FIM CAIXA ENGLOBA GERENCIAMENTO -->
		
		
		
		
		
		
		
		
		
		
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<?
			}
			?>
				
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>