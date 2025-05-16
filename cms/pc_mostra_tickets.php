<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?php include("pc_valida_id_pesquisa.php"); ?>

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
<script type="text/javascript">
	
function checkall()
{
        for(i = 0; i < document.forms[0].elements.length; i++)
        {
        
        temp = document.forms[0].elements[i];
        
                        if( temp.checked == true )
                {
                        temp.checked = false;
                        
                }
                else
                {
                        temp.checked = true;
                        
                }
        }
}
	
</script>
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
            <form id="form_tickets" name="form_tickets" action="pc_gera_cartas.php" target="_blank" method="post">
                
                <?php
                    
$id_pesquisa = $_GET['id_pesquisa'];
                    $total = mysql_query("
                    SELECT
                    codigo,
                    date_format(created,'%d/%m/%Y %H:%i:%s') AS data,
                    comecado,
                    finalizado
                    FROM
                    pc_ticket
                    WHERE
                    id_pesquisa=$id_pesquisa
                    ORDER BY data DESC");

                    $total = mysql_num_rows($total);
                    
                    
                    
                    $limite = 350;
                    $pags = floor($total / $limite);
                    
                    if(isset($_GET["p"])) {
                        $p = $_GET["p"];
                    } else {
                        $p = 1;
                    }
                    
                    $atual = ($p*$limite)-$limite;
                    
                    
                ?>
                <style>
                #paginacao {
                    font-family: Arial;
                    font-size: 14px;
                }                
                
                #paginacao a {
                    padding: 5px;
                    border: 1px solid #000;
                    text-decoration: none;
                }
                
                #paginacao ul {
                    float: left;
                    padding: 0px;
                }
                
                #paginacao li {
                    list-style: none;
                    display: inline;
                }
                </style>
                <div id="paginacao">
                     
                    <ul>
                        <li style="font-size: 16px;">Página: </li>
                    <? for($i = 1; $i <= $pags; $i++) { ?>
                        <li><a <? if($p == $i) { echo "style='background: #E8E8E8; text-decoration: underline;'"; } ?> href="?id_pesquisa=<?=$id_pesquisa?>&p=<?=$i?>"><?=$i?></a></li>
                    <? } ?>
                    </ul>    
                </div>
                
				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
                        <td align="center">#</td>
						<td align="center">Número do Ticket</td>
						<td align="center">Data</td>
                        <td align="center">Usado</td>
                        <td align="center">Finalizado</td>
                        <td align="center" width="11%">Ações<br /><a href="javascript: void(0);" onClick="checkall()">Marcar / Desmarcar todos</a></td>
					</tr>
				
					
			<?




$sql = "
SELECT
codigo,
date_format(created,'%d/%m/%Y %H:%i:%s') AS data,
comecado,
finalizado
FROM
pc_ticket
WHERE
id_pesquisa=$id_pesquisa
ORDER BY data DESC 
                ";
				//echo $sql;
               
                
                
                
				$result = mysql_query($sql);
				$i = $atual;
				while ($linha = mysql_fetch_assoc($result)) {
			     $i++;
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
                        <td align="center" ><?=$linha["codigo"]?></td>

						<td align="center" ><?=$linha["data"]?> </td>	
                        <td align="center" >
                        <?
                            if ($linha["comecado"] == 0) {
                                echo "<span style=\"color: #FF0000;\">Não</span>";
                            } else {
                                echo "<span style=\"color: #69d400;\">Sim</span>";
                            }
                        ?>
                        </td>
                        <td align="center" >
                        <?
                            if ($linha["finalizado"] == 0) {
                                echo "<span style=\"color: #FF0000;\">Não</span>";
                            } else {
                                echo "<span style=\"color: #69d400;\">Sim</span>";
                            }
                        ?>
                        </td>				 

								
						<td align="center" width="1%" nowrap>							
                            Gerar carta
                            <input type="checkbox" value="<?= $linha["codigo"]?>" name="codigo[]" />
						</td>

								
				<?
                }
                ?>	
					</tr>
                    

				</table>
			
            	<input type="hidden" name="id_pesquisa" value="<?= $id_pesquisa ?>" />
            
				<input class="form_style" type="submit" value="Gerar cartas" style="padding:5px 20px; font-size:16px; float:right; margin-right:10px;" />
                
                <div style="clear:both"></div>
                
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
			
            </form>
            <!-- FIM DO FORMULARIO-->
				
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