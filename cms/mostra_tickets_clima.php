<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

if ($_REQUEST["cod"]){
    $cod = $_REQUEST["cod"];
}

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
				<img src="imagens/barra_tickets.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
                        <td align="center">#</td>
						<td align="center">Número do Ticket</td>
						<td align="center">Cliente</td>
						<td align="center">Data</td>
                        <td align="center">Usado?</td>
                        <td align="center">Ações</td>
					</tr>
				
					
			<?
				$sql = "
SELECT
organizacoes.nome,
grupo_tickets_clima.id_cliente,
grupo_tickets_clima.data_gera,
date_format(data_gera,'%d/%m/%Y %H:%i:%s') AS data1,
tickets_clima.usou,
tickets_clima.ticket
FROM
tickets_clima
Left Join grupo_tickets_clima ON tickets_clima.id_agrupa = grupo_tickets_clima.id
Left Join organizacoes ON grupo_tickets_clima.id_cliente = organizacoes.id
WHERE
id_agrupa='$cod'
ORDER BY usou DESC
                ";
                
                //echo $sql;
                
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
			     $i++;
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
                        <td align="center" ><?=$linha["ticket"]?></td>
						<td align="center" ><?=$linha["nome"]?> </td>

						<td align="center" ><?=$linha["data1"]?> </td>	
                        <td align="center" >
                        <?
                            if ($linha["usou"] == 0) {
                                echo "<span style=\"color: #FF0000;\">Não</span>";
                            } else {
                                echo "<span style=\"color: #69d400;\">Sim</span>";
                            }
                        ?>
                        </td>				 

								
						<td align="center" width="1%" nowrap>							
                            <a href="cartapdf_clima.php?cod=<?=$linha["ticket"]?>" target="_blank"><img src="imagens/icon_email.gif" title="Gerar Carta" alt="Gerar Carta" border="0" ></a>
						</td>

								
				<?
                }
                ?>	
					</tr>

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