<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$pedido = $_REQUEST['cod'];
	$sql = "DELETE FROM gerador_tickets_pedidos WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM gerador_tickets WHERE num_pedido=".$_REQUEST['cod'];
	if (mysql_query($sql)and(mysql_query($sql2))) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
		$ok =1;
		       
		if($_POST["quant"] != "")
		{
		$quant = $_POST["quant"];
		}else{
			$quant = 1;
		}
		
		if($_POST["orga"] != "")
		{
		$orga = $_POST["orga"];
		}else{
			$ok = 0;
		}
		
		if($_POST["pesquisa"] != "")
		{ 
		$pesquisa = $_POST["pesquisa"];
		}else{
			$ok = 0;
		}
		
		if(!$ok){
			alert("Preencha o campos cnpj corretamente");
			$quant = "";
		}else{
			$data = date("Y-m-d H:i:s");
    		//// GERANDO PEDIDO 
    		$sql_pedidos_gera = "INSERT INTO grupo_tickets_clima (id_cliente,id_pesquisa, data_gera, quantidade) VALUES('$orga','$pesquisa','$data','$quant')";
    		//echo $sql_cadastra."<br><br>";
    		
            //echo $sql_pedidos_gera;
            
            if (mysql_query($sql_pedidos_gera)) {
                //Pegando o ID do agrupamento recem cadastrado
                $id_agrupa = id_agrupamento($data,$orga,$quant,$pesquisa);
                // Gerando os tickets
                gera_tickets_clima($id_agrupa,$quant,$pesquisa,$orga);
                alert("Tickets gerados com sucesso!");
                redireciona("gerar_tickets_clima.php");
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
		
		  <? if($codigo_usuario != "180") { ?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_gera_ticket.gif" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="gerar_tickets_clima.php?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return Validar();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização:</span> </div>

						<?
						if($organizacaon){
							$whereorga = " WHERE id='$organizacaon'";
						}
				          $sql = "SELECT * FROM `organizacoes` $whereorga ORDER BY `nome`";
				          $result = mysql_query($sql);
				          //echo $result;
				          ?>
				          <select name="orga" style="width:200px;" class="form_style">
				          <option value="" selected="selected">Selecione</option>
				
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
					<div id="label"> <span class="label_fonte">Pesquisa: </span> </div>
					<select name="pesquisa" class="form_style" id="idpesquisa">
						<option value="">Selecione</option>
						<? 	$sql = "SELECT * FROM pesquisas ORDER BY nome";
							$result = mysql_query($sql);
							while ($linha = mysql_fetch_assoc($result)) {
	
						?>						
						  <option value="<?=$linha["id"]?>"><?=$linha["nome"]?></option>
						
						<?}?>
					</select>
				</div>                
					
			
			
			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Digite a quantidade de tickets: </span> </div><input type="text" size="4" name="quant" value="<?=$quant;?>" class="form_style">
			
			</div>


				<p align="center"><input type="submit" value="Gerar Tickets" class="form_style"></p>
				
				
			
				</div></form>
		
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->	

            <? } ?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_tickets.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Agrupamento</td>
						<td align="center">Número de Tickets</td>
                        <td align="center">Respondidos</td>
						<td align="center">Data</td>
						<td align="center">Cliente</td>
						<td align="center">Nome Pesquisa</td>
                        <td align="center">Tela Cliente</td>
                        <td align="center">Ações</td>
					</tr>
				
					
			<?
                if($codigo_usuario == "180")
                {
                    $where = "WHERE grupo_tickets_clima.id = 8";
                }
            
				$sql = "
                    SELECT
                    grupo_tickets_clima.id,
                    grupo_tickets_clima.id_cliente,
                    grupo_tickets_clima.id_pesquisa,
                    grupo_tickets_clima.data_gera,
                    grupo_tickets_clima.quantidade,
                    date_format(data_gera,'%d/%m/%Y %H:%i:%s') AS data1,
                    organizacoes.nome AS nome_orga,
                    pesquisas.nome AS nome_peq
                    FROM
                    grupo_tickets_clima
                    Left Join organizacoes ON grupo_tickets_clima.id_cliente = organizacoes.id
                    Left Join pesquisas ON grupo_tickets_clima.id_pesquisa = pesquisas.id
                    $where ORDER BY id desc
                ";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["id"]?></td>
                        <td align="center" ><?=$linha["quantidade"]?></td>
						<td align="center" >
                        <?
                        if($linha["id"] != 8)
                        {
                            $sql2 = "
                            SELECT
                            tickets_clima.ticket,
                            tickets_clima.id_agrupa,
                            tickets_clima.usou
                            FROM
                            tickets_clima
                            WHERE
                            tickets_clima.id_agrupa =  '".$linha["id"]."' AND
                            tickets_clima.usou =  '1'
                            ";
                            //echo $sql2;
                            $result2 = mysql_query($sql2);
                            $num = mysql_num_rows($result2);
                            echo $num;
                        } else { ?>
                            
                            <?
                             $id_agrupa = 8; 
                             $id_pesq = 7;
                                // Selecionando Perguntas
                                $sql_unidade = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa=7 and formato_perguntas=2 ORDER BY pesquisa_perguntas.id"; 
                                $result_unidade = mysql_query($sql_unidade);
                                $linha_unidade = mysql_fetch_assoc($result_unidade);
                                $alternativas_unidade = $linha_unidade["alternativas"];
                                $unidades = explode("|",$alternativas_unidade);
                                
                            ?>
                            
                            
                            
                            <? for ($i=0;$i<=count($unidades)-3;$i++) {?>
                               
                                <? if($i <= 35) { //Diretoria Técnica Assistencial ?>
                                    <? $a1_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                <? if($i <= 72 and $i >= 36) { //Diretoria de Hotelaria e Administração ?>
                                    <? $a2_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                <? if($i <= 97 and $i >= 73) { //Diretoria Financeira ?>
                                    <? $a3_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                <? if($i <= 99 and $i >= 97) { //Diretoria de Projetos ?>
                                    <? $a4_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                <? if($i >= 105 and $i <= 108) { //Diretoria Clínica ?>
                                    <? $a5_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                
                                <? if($i >= 100 and $i <= 101) { //Diretoria Clínica ?>
                                    <? $a6_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                                
                                <? if($i >= 102 and $i <= 104) { //Diretoria Clínica ?>
                                    <? $a7_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
                                <? } ?>
                            <? } ?>
                            
                            <?
                            echo $a1_resp + $a2_resp + $a3_resp + $a4_resp + $a5_resp + $a6_resp + $a7_resp; 
                            
                        }
                        
                        ?>
                        </td>
						<td align="center" ><?=$linha["data1"]?> </td>
						<td align="center" ><?=$linha["nome_orga"]?> </td>
						<td align="center" ><?=$linha["nome_peq"]?> </td>
						<td align="center" ><a href="http://www.appweb.com.br/cms/tickets_cliente.php?cod=<?=$linha["id"]?>">http://www.appweb.com.br/cms/tickets_cliente.php?cod=<?=$linha["id"]?></a> </td>
						<? 
							$permissao = $_SESSION["per_adm"];
							if($permissao == "9999"){?>
						<td align="center" width="1%" nowrap>
							
							<a href="enviar_email.php?cod=<?=$linha["id"]?>"><img src="imagens/manda_imail.gif" title="Enviar Email" alt="Enviar Email" border="0"></a>	
							

							
							<a href="gerar_tickets_pedidos.php?cod=<?=$linha["id"]?>"><img src="imagens/icon_ver.gif" title="Ver tickets" alt="Ver tickets" border="0"></a>
							
							<a href="gerar_tickets.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o ticket ?')" alt="Apagar" border="0"></a>
							
						 
							</td>
								<?} else {?>
								
								<td align="center" width="1%" nowrap>
        							<a href="verPesquisaClima_tickets.php?cod=<?=$linha["id"]?>&id_pesq=<?=$linha["id_pesquisa"]?>" target="_blank">
            									<img src="imagens/icon_pizza.PNG"  title="PIZZA" alt="PIZZA" border="0">
            							</a>
                                        
                                     <? if($codigo_usuario != "180") { ?>    
                                    <a href="cartapdf_clima_completa.php?cod=<?=$linha["id"]?>" target="_blank"><img src="imagens/icon_email.gif" title="Gerar Carta Completa" alt="Gerar Carta Completa" border="0" ></a>							
    								<a href="mostra_tickets_clima.php?cod=<?=$linha["id"]?>"><img src="imagens/icon_ver.gif" title="Ver tickets" alt="Ver tickets" border="0"></a>
								    <?}?>
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