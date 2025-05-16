<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$pedido = $_REQUEST['cod'];
	$sql = "DELETE FROM gerador_tickets_pedidos_app WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM gerador_tickets_app WHERE num_pedido=".$_REQUEST['cod'];
	if (mysql_query($sql)and(mysql_query($sql2))) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
		$ok =1;
	
		if($_POST["cnpj"] != "")
    		{
    		$cnpj = $_POST["cnpj"];
    		}else{
    			$ok = 0;
    		}
            
            if($_POST["email"] != "")
    		{
    		$email = $_POST["email"];
    		}else{
    			$ok = 0;
    		}
	
		
		

            if($_POST["orga"] != "")
    		{
    		$orga = $_POST["orga"];
    		}else{
    			$ok = 0;
    		}


            
            if($_POST["grup"] != "")
    		{
    		$grup = $_POST["grup"];
    		}else{
    			$ok = 0;
    		}
			

		
		if($_POST["quant"] != "")
		{
		$quant = $_POST["quant"];
		}else{
			$quant = 1;
		}
		
		
		if($_POST["nome_cliente"] != "")
		{
		$nome_cliente = $_POST["nome_cliente"];
		}else{
			$ok = 0;
		}
		
		
		
		if($_POST["cidade"] != "")
		{
		$cidade = $_POST["cidade"];
		}else{
			$ok = 0;
		}
		
		if($_POST["estado"] != "")
		{
		$estado = $_POST["estado"];
		}else{
			$ok = 0;
		}
		
        /*
		if($_POST["cod_cliente"] != "")
		{
		$cod_cliente = $_POST["cod_cliente"];
		}else{
			$ok = 0;
		}
        */
		

		$nome_responsavel = $_POST["nome_responsavel"];
		$cargo_responsavel = $_POST["cargo_responsavel"];

		
		
		
		
		
		
		
		if(!$ok){
			alert("Preencha o campos corretamente");
			$quant = "";
		}else{
			$data = date("Y-m-d H:i:s");
		
		//// GERANDO PEDIDO 
		$sql_pedidos_gera = "INSERT INTO gerador_tickets_pedidos_app (cnpj,data_gerado, nome_cliente, cidade, estado, organizacao, grupo, email, nome_responsavel, cargo_responsavel) VALUES ('$cnpj','$data','$nome_cliente','$cidade','$estado','$orga','$grup','$email','$nome_responsavel','$cargo_responsavel')";
		//echo $sql_pedidos_gera."<br><br>";

		mysql_query($sql_pedidos_gera) or die(mysql_error());
		//echo 1;
		$sql_pedidos_id = "SELECT * FROM gerador_tickets_pedidos_app WHERE cnpj = '$cnpj' order by id desc";
		$result_pedidos_id = mysql_query($sql_pedidos_id);
		$linha_pedidos_id = mysql_fetch_assoc($result_pedidos_id);
		$numero_pedido = $linha_pedidos_id["id"];
		/// FIM DO PEDIDO
		
		$numeros_tickets = array();
		
	
	
		//echo $numeros;
		$c = 1;
		
		for ($i=1;$i<=$quant;$i++){
				$ok = 1;
				$numeros = mt_rand(1, 999999);
		while($ok>0){
			
			$sql = "SELECT * FROM gerador_tickets WHERE numero_ticket = $numeros";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0){
				$numeros = mt_rand(1, 999999);
			}else{
				$numeros_tickets[$i] = $numeros;
				$sql_cadastra = "INSERT INTO gerador_tickets (num_pedido,numero_ticket,organizacao,grupo) VALUES ('$numero_pedido','$numeros','$orga','$grup')";
				//echo $sql_cadastra."<br><br>";
				mysql_query($sql_cadastra) or die(mysql_error());
				$ok = 0;
			}
			
		}
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
		<script>
        $(document).ready(function() {
           
                $("#grupo").attr("disabled",true);
            
        })
       
        function get_grupos() {

        value = $("#orgs").val();
        $.ajax({ 
			url: 'pegar_grupos.php',
			type: 'POST',
			data: ({
				id: value
			}),
            
			 success: function(data){
		     
		     if(data != "fail") {
			    $("#grupo").removeAttr("disabled");
                $("#grupo").html('<option value="(escolha)" selected="selected">(escolha)</option>');
			    $("#grupo").append(data);
             } else {
                $("#grupo").html('<option value="(escolha)" selected="selected">(escolha)</option>');
                $("#grupo").attr("disabled",true);
             }
			}					  
	   });            
            
      }
      
      function valida_form() {
        msg = '';
        cont = true;
        if(!$("#nome_cliente").val()) {
            cont = false;
            msg += 'Digite o Nome do Cliente.\n';
        }
        
        if(!$("#cidade").val()) {
            cont = false;
            msg += 'Digite a cidade.\n';
        }
        
        if(!$("#estado").val()) {
            cont = false;
            msg += 'Digite o estado.\n';
        }
        
        if($("#orgs").val() == "(escolha)") {
            cont = false;
            msg += 'Escolha a organização.\n';
        }
        
        if($("#grupo").val() == "(escolha)") {
            cont = false;
            msg += 'Escolha o grupo.\n';
        }
        
        if(!$("#nome_resp").val()) {
            cont = false;
            msg += 'Digite o nome do responsável.\n';
        }
        
        if(!$("#cargo_resp").val()) {
            cont = false;
            msg += 'Digite o cargo do responsável.\n';
        }
        
        if(!$("#email").val()) {
            cont = false;
            msg += 'Digite o e-mail.\n';
        }
        
        if(!$("#cpf").val()) {
            cont = false;
            msg += 'Digite o CPF/CNPJ.\n';
        }
        
        if(!$("#qtd").val()) {
            cont = false;
            msg += 'Digite a quantidade de tickets.\n';
        }
        
        if(msg != '') {
        alert(msg);
        }
        return cont;
      }
      </script>
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_gera_ticket.gif" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="gerar_tickets_app.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return valida_form();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			
			
			<div id="linha_form" >
				<div id="label" style="width: auto;">
					<span class="label_fonte" style="margin-right: 10px">Nome do Cliente: </span>
					<input type="text" size="30" name="nome_cliente" id="nome_cliente" value="<?=$nome_cliente;?>" class="form_style">	
				</div>
							
				
				
				<div id="label" style="width: auto;">
					<span class="label_fonte" style="margin-right: 10px; margin-left: 20px">Cidade: </span>
					<input type="text" size="20" id="cidade" name="cidade" value="<?=$cidade;?>" class="form_style">	
				</div>
							
				
				
				<div id="label" style="width: auto;">
					<span class="label_fonte" style="margin-right: 10px; margin-left: 20px">Estado: </span>
					<input type="text" size="4" name="estado" id="estado" value="<?=$estado;?>" class="form_style">	
				</div>
				
			</div>
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
			    <? 
                  $sql = "SELECT * FROM `organizacoes` WHERE pg_organizacao = 1 ORDER BY `nome`";
                  $result = mysql_query($sql);
                  //echo $result;
                  ?>
                <select name="orga" id="orgs" onchange="get_grupos()">
                  <option value="(escolha)" selected="selected">(escolha)</option>
        
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
			
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Grupo: </span> </div>
                <? if($_POST["orga"]){
                	$id = $_POST["orga"];
        	    	$where = "where `id_organizacao` = $id";
        	   	}else{
            		$where = "where `id_organizacao` = $id";
            	}?>
        
        
                <select name="grup" id="grupo" >
                  <option value="(escolha)" selected="selected">(escolha)</option>
                  <?
                  $sql = "SELECT *
        				FROM `grupos`
        				$where
        				ORDER BY `nome`";
                  $result = mysql_query($sql);
                  //echo $result;
                  ?>
                  
                 <? while ($linha = mysql_fetch_assoc($result)) {
                 	
                 	$id = $_POST["grup"];
                  	if($linha["id"] == $id){
                  		$select = " SELECTED ";
                  	}else{
                  		$select = " ";
                  	}
                 	
                 	?>
                  	<option value="<?=$linha["id"]?>" <?=$select?>><?=$linha["nome"]?></option>
                 <? } ?>
                </select>
                
			</div>	
			
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Nome do Responsável: </span> </div><input type="text" size="30" name="nome_responsavel" id="nome_resp" value="<?=$nome_responsavel;?>" class="form_style">
			
			</div>	
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Cargo do Responsável: </span> </div><input type="text" size="30" name="cargo_responsavel" id="cargo_resp" value="<?=$cargo_responsavel;?>" class="form_style">
			
			</div>	
			
			
			
			
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">E-mail: </span> </div><input type="text" size="30" name="email" id="email" value="<?=$email;?>" class="form_style" onBlur="is_email();">
			
			</div>	
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">CPF / CNPJ: </span> </div><input type="text" size="30" name="cnpj" id="cpf" value="<?=$cnpj;?>" class="form_style">
			
			</div>	
			
			<!--
			<div id="linha_form">
				<div id="label"><span class="label_fonte">Código do Cliente</span></div><input type="text" size="20" name="cod_cliente" value="<?=$cod_cliente;?>" class="form_style">
			
			</div>
			-->
			
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Digite a quantidade: </span> </div><input type="text" size="4" name="quant" id="qtd" value="<?=$quant;?>" class="form_style">
			
			</div>
			
			
			<div id="linha_form_auto">
				<div id="label"> <span class="label_fonte">Pedido <b><?=$numero_pedido?></b>  -  Numero do(s) ticket(s) :</span></div><br/>
				<?
					for ($i=1;$i<=$quant;$i++){
						echo "<b>".$numeros_tickets[$i]."</b><br>";
					
				}
				?>
			</div>

				<p align="center"><input type="submit" value="Gerar Tickets" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->	
				
				
			<form action="gerar_tickets_app.php?localizar=1" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">

				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Palavra:</span> </div>

						<input class="form_style" type="text" size="50" name="palavra">
				     <div id="label"> <span class="label_fonte"><a href="gerar_tickets_app.php" target="_parent">Mostra todos os pedidos.</a></span> </div>
				</div>	
				
				<p align="center"><input type="submit" value="Localizar" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>		
			
			<?
			 if($_REQUEST["localizar"]){
				$palavra = $_POST["palavra"];
			 	
			 	if($palavra != ""){
			 	$texto_palavra = "WHERE nome_cliente like '%$palavra%' or 
			 				cidade like '%$palavra%' or
			 				estado like '%$palavra%'
			 	";
			 	}else{
			 		$texto_palavra ="";
			 	}
			 	
			 	
			}
				
			?>

			
			
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->		
					
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_tickets.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Pedido</td>
						<td align="center">Número de Tickets</td>
						<td align="center">Data</td>
						<!--<td align="center">Código do Cliente</td>-->
						<td align="center">Nome Responsável</td>
						<td align="center">Cargo Responsável</td>
						<td align="center">E-mail</td>
						<td align="center">CPF / CNPJ</td>
						<td align="center">Nome do Cliente</td>
						<td align="center">Cidade</td>
						<td align="center">Estado</td>
					
							<? 
							//$permissao = $_SESSION["per_adm"];
						//	if($permissao == "9999"){?>
						<td align="center">A&ccedil;&otilde;es</td>
						<?//}?>
					</tr>
				
					
			<?
				$sql = "SELECT *,date_format(data_gerado ,'%d/%m/%Y %H:%i:%s') AS `data1` FROM gerador_tickets_pedidos_app $texto_palavra ORDER BY id desc";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["id"]?></td>
						<td align="center" ><?
						
						$pedido = $linha["id"];
						$sql2 = "SELECT * FROM gerador_tickets WHERE num_pedido = $pedido  ORDER BY id";
						$result2 = mysql_query($sql2);
						echo mysql_num_rows($result2);
								
						
						?> </td>
						<td align="center" ><?=$linha["data1"]?> </td>
						<!--<td align="center" ><?=$linha["cod_cliente"]?> </td>-->
						<td align="center" ><?=$linha["nome_responsavel"]?> </td>
						<td align="center" ><?=$linha["cargo_responsavel"]?> </td>
						<td align="center" ><?=$linha["email"]?> </td>
						<td align="center" ><?=$linha["cnpj"]?> </td>
						<td align="center" ><?=$linha["nome_cliente"]?> </td>
						<td align="center" ><?=$linha["cidade"]?> </td>
						<td align="center" ><?=$linha["estado"]?> </td>
						
						<? 
							$permissao = $_SESSION["per_adm"];
                            //echo $permissao;
							if($permissao == "9999" or $permissao == "99991"){?>
						<td align="center" width="1%" nowrap>
							
						<!--	<a href="enviar_email.php?cod=<?=$linha["id"]?>"><img src="imagens/manda_imail.gif" title="Enviar Email" alt="Enviar Email" border="0"></a>	-->
							
							
							<a href="gerar_tickets_pedidos.php?cod=<?=$linha["id"]?>"><img src="imagens/icon_ver.gif" title="Ver tickets" alt="Ver tickets" border="0"></a>
							
							<a href="gerar_tickets_app.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o ticket ?')" alt="Apagar" border="0"></a>
							
							
							<!--<a href="cartapdf.php?cod=<?=$linha["id"]?>" target="_blank"><img src="imagens/icon_email.gif" title="Gerar Carta" alt="Gerar Carta" border="0" ></a>-->
						
							</td>
								<?} else {?>
								
								<td align="center" width="1%" nowrap>
									<!--<a href="enviar_email.php?cod=<?=$linha["id"]?>"><img src="imagens/manda_imail.gif" title="Enviar Email" alt="Enviar Email" border="0"></a>	-->
								
							<!--	<a href="gerar_tickets_pedidos.php?cod=<?=$linha["id"]?>"><img src="imagens/icon_ver.gif" title="Ver tickets" alt="Ver tickets" border="0"></a>
								<a href="cartapdf.php?cod=<?=$linha["id"]?>" target="_blank"><img src="imagens/icon_email.gif" title="Gerar Carta" alt="Gerar Carta" border="0" ></a>-->
								</td>
								
								<?}?>
								
								
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