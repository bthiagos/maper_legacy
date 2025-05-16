<?php include("conn.php"); ?>

<?php include("logon.php"); ?>

<?php include("library.php"); ?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<?php include("header.php"); ?>

<script src="js/editinplace.js"></script>

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
			<?php
				if($permissao == "99991"){
			?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="height: 25px;">
				<div style="font-family: Arial; font-size: 16px; color: #727272;">Busca</div> 
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="telefones_clientes.php?order=1" method="post" name="cadastro" enctype="multipart/form-data">
			
				<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
				<div id="caixa_form">
				
					<div id="linha_form">
						<div id="label"> <span class="label_fonte">Organizar por: </span> </div>
						<select name="organizar" class="form_style">
							<?php $org = (isset($_POST['organizar'])) ? $_POST['organizar'] : 1; ?> 
							<option <?php if($org == 1 ){ ?> SELECTED <?php } ?> value="1">Nome</option>
							<option <?php if($org == 2 ){ ?> SELECTED <?php } ?> value="2">Data de realiza&ccedil;&atilde;o</option>
						</select>
					</div>	
					<div id="linha_form">
						<div id="label"> <span class="label_fonte">Organiza&ccedil;&atilde;o: </span> </div>
						<select name="orga" class="form_style">
							<option value="0">Selecione</option>
							<?php
							$org = (isset($_POST['orga'])) ? $_POST['orga'] : 0;
							$sql = "SELECT id,nome FROM organizacoes ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
								if ($org == $linha["id"]) {
									$select = "SELECTED";
								}else{
									$select = "";
								}
							?>
								<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
							<?php
							}
							?>
						</select>
						
						
					</div>
					
					<p align="center"><input type="submit" value="Buscar" class="form_style"></p>
				</div>
				<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->
			

		

			<!-- INICIO - DIV info - Barra de informacao -->
			<?php 
					
					 if(isset($_GET['order'])){
					 	if($_POST['organizar']==1){
					 		
							$order = "ORDER BY a.nome ASC";
						}else if($_POST['organizar']==2){
							
							$order = "ORDER BY a.data_aplic ASC";
						}
						
						if($_POST['orga'] > 0){
							$where = ' and a.organizacao='.$_POST['orga'];
						}	
						
					 }else{
					 	$where = "";
					 	$order = "ORDER BY a.nome ASC";
					 }
			?> 
			<div id="info" style="height: 25px;">

				<div style="font-family: Arial; font-size: 16px; color: #727272;">Contato dos clientes </div>   

			</div>

			<!-- INICIO - DIV info - Barra de informacao -->
			
			<div id="caixa_table">
				<table width="100%" align="center" class="sortable" cellspacing="3">
	
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data Aplica&ccedil;&atilde;o</td>
						<td align="center">Oraniza&ccedil;&atilde;o</td>
						<td align="center">Nome</td>
						<td align="center">E-mail</td>
	                    <td align="center">Telefone (Whatsapp)</td>
					</tr>
					
					<?php
						$sql = "SELECT distinct a.id,a.nome,a.email,a.telefone,DATE_FORMAT(a.data_aplic,'%d/%m/%Y') as data_aplic,o.nome as nome_organizacao FROM aplicacoes as a 
						left join organizacoes as o ON  o.id = a.organizacao
						where a.nome <> '' and a.telefone <> '' ".$where." ".$order."";
						

						$result = mysql_query($sql);
						while ($linha = mysql_fetch_assoc($result)) {
					?>
							<tr height="30" class="cel_fonte">
								<td align="center"><?=$linha['id']?></td>
								<td align="center"><?=$linha['data_aplic']?></td>
								<td align="center"><?=$linha['nome_organizacao']?></td>
								<td align="left"><?=$linha['nome']?></td>
								<td align="left"><?=$linha['email']?></td>
								<td align="center"><?=$linha['telefone']?></td>
							</tr>
					<?php
						}
					?>
				</table>
			
			</div>
			<?php } ?>
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


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->

</body>

<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>

</html>		
