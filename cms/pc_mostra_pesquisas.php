<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


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
				<img src="imagens/gerencia_pesquisa.jpg" alt="Gerenciamento de Pesquisas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
                        <td align="center">#</td>
						<td align="center">Nome da pesquisa</td>
                        <td align="center">Limite de tickets</td>
                        <td align="center">Qtd. tickets disponíveis</td>
                        <td align="center">Ações</td>
					</tr>
				
					
			<?
				$sql = "
                SELECT
                id,
                nome,
                limite,
                tickets_gerados
                FROM
                pc_pesquisa
                WHERE
                empresa=".$_SESSION["id_usuario_adm"]."
                ORDER BY nome";
                
                //echo $sql;
                
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
					
					$qtd_disponivel = $linha['limite'] - $linha['tickets_gerados'];
					
			     $i++;
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i?></td>
                        <td align="center" ><?=$linha["nome"]?></td>
						<td align="center" width="150"><?=$linha["limite"]?> </td>
						<td align="center" width="150"><?=$qtd_disponivel?> </td>	
						<td align="center" width="1%" nowrap>							
                        	<a href="pc_filtros.php?id=<?=$linha['id']?>" target="_blank"><img src="imagens/icon_barra.png" title="Gerar Relatórios" alt="Gerar Relatórios" border="0" ></a>
                            <a href="pc_gera_tickets.php?id_pesquisa=<?= $linha['id'] ?>"><img src="imagens/tickets.png" title="Gerar Tickets" alt="Gerar Tickets" border="0" ></a>
                            <img onclick="tickets_mostra('<?=$linha['id']?>')" src="imagens/relatorio_tickets.png" title="Relatório de Ticket" alt="Relatório de Ticket" border="0" style="cursor: pointer;" width="25" />
                            <a href="pc_mostra_tickets.php?id_pesquisa=<?= $linha['id'] ?>"><img src="imagens/icon_ficha.gif" title="Listar Tickets" alt="Listar Tickets" border="0" ></a>
						</td>
                        
                        
	           <?php
                    //GERADOR DE RELATORIO TICKET
                    $id_pesquisa = $linha['id'];
                    
                    $sql_tickets = mysql_query("SELECT p.limite FROM pc_pesquisa p LEFT JOIN pc_ticket t ON t.id_pesquisa = p.id WHERE p.id = '$id_pesquisa' GROUP BY t.codigo");
                    $limite = mysql_result($sql_tickets,0,'limite');
                    $gerados = mysql_num_rows($sql_tickets);
                    
                    $sql_usados = mysql_query("SELECT id FROM pc_ticket WHERE comecado = '1' and id_pesquisa = '$id_pesquisa'");
                    $usados = mysql_num_rows($sql_usados);
                    
                    $sql_concluidos = mysql_query("SELECT id FROM pc_ticket WHERE finalizado = '1' and id_pesquisa = '$id_pesquisa'");
                    $concluidos = mysql_num_rows($sql_concluidos);
                    
                    //echo $limite."/".$gerados."/".$usados."/".$concluidos;
                    $limite_add = $limite * 20 / 400;
                    $cores = array('1E90FF','228B22','CD0000','EEEE00','FFA500','FFB5C5','CDC9C9','9370DB','A52A2A','000000');
                    $limite2 = $limite + $limite_add;
                ?>
                <div id="relatorio_<?=$id_pesquisa?>" class="relatorio_tickets">
                    <div class="relatorio_interno">
                        <div style="float: right;"><img src="imagens/x.png" style="cursor: pointer;" onclick="tickets_fecha('<?=$linha['id']?>')" /></div>
                        <h1>Relatório de Tickets</h1>
                        <img src="http://chart.googleapis.com/chart?chxr=0,0,<?=$limite2?>&chxt=y&chbh=a,4,10&chs=700x350&cht=bvg&chco=<?=$cores[0]?>,<?=$cores[1]?>,<?=$cores[2]?>,<?=$cores[4]?>&chds=0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>&chd=t:<?=$limite?>|<?=$gerados?>|<?=$usados?>|<?=$concluidos?>&chdl=Tickets+M%C3%A1ximos|Tickets+Gerados|Tickets+Usados|Tickets+Conclu%C3%ADdos&chm=N,000000,0,-1,14&chm=N,000000,0,-1,14|N,000000,1,-1,14|N,000000,2,-1,14|N,000000,3,-1,14" width="700" alt="Tickets" />
                    </div>
                </div>
    
				<?
                }
                ?>	
					</tr>
                    
				</table>
                <style>
                    .relatorio_tickets {
                        display: none;
                        position: fixed;
                        z-index: 99999;
                        top: 0px;
                        left: 0px;
                        width: 100%;
                        height: 100%;
                        text-align: center;
                        background: url('imagens/transp.png');
                    }
                    
                    .relatorio_tickets .relatorio_interno {
                        width: 750px;
                        padding: 20px;
                        text-align: center;
                        background: #FFF;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        margin-left: -350px;
                        margin-top: -175px;
                    }
                    
                    .relatorio_tickets h1 {
                        width: 750px;
                        font-size: 21px;
                        margin: 0px;
                        padding: 0px;
                        margin-bottom: 5px;
                        font-family: Arial;
                    }
                </style>
                <script>
                    function tickets_mostra(qual) {
                        $("#relatorio_"+qual).fadeIn();
                    }
                    
                    function tickets_fecha(qual) {
                        $("#relatorio_"+qual).fadeOut();
                    }
                </script>

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