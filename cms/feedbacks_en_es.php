<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	foreach($_POST as $k => $v) {

        if(strpos($k,"desc_pt_") !== false) {
            $id_ex = explode("_",$k);
            $id = end($id_ex);
            mysql_query("UPDATE feedbacks SET descricao = '".addslashes($v)."' WHERE feedbacks_id = '$id'");
        }
	   
        if(strpos($k,"desc_en_") !== false) {
            $id_ex = explode("_",$k);
            $id = end($id_ex);
            mysql_query("UPDATE feedbacks SET descricao_en = '".addslashes($v)."' WHERE feedbacks_id = '$id'");
        }
        
        if(strpos($k,"desc_es_") !== false) {
            $id_ex = explode("_",$k);
            $id = end($id_ex);
            mysql_query("UPDATE feedbacks SET descricao_es = '".addslashes($v)."' WHERE feedbacks_id = '$id'");
        }
       
	}
    
    alert("Alterações salvas!");
    redireciona("feedbacks_en_es.php");

}
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
				<h2>Tradução dos Feedbacks das Aplicações</h2>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			<form action="?cadastra=1" method="POST">
            
            <p align="center"><input type="submit" value="Salvar Alterações" class="form_style" /></p>
			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" width="100">Competência</td>
						<td align="center" width="30">Nota</td>
						<td align="center">Texto em Português</td>
						<td align="center">Texto em Inglês</td>
						<td align="center">Texto em Espanhol</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM feedbacks ORDER BY competencia_id,nota ASC";
				$result = mysql_query($sql);
				$c = 0;
				while ($linha = mysql_fetch_assoc($result)) {
				    $c++;
                    ?>
                    <tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
                       
                        <td align="center" valign="middle">
                            <?
                                $sql_competencias = mysql_query("SELECT * FROM competencias WHERE competencias_id = '".$linha["competencia_id"]."'");
                                $competencia = mysql_fetch_array($sql_competencias);
                                echo $competencia["descricao"];
                            ?>
                        </td>
                        <td align="center" valign="middle">
                            <?=$linha["nota"]?>
                        </td>
                        <td align="center" valign="middle">
                            <textarea name="desc_pt_<?=$linha["feedbacks_id"]?>" style="width: 99%; height: 120px; font-family: Arial; font-size: 12px; line-height: 120%"><?=$linha["descricao"]?></textarea>
                        </td>
                        <td align="center" valign="middle">
                            <textarea name="desc_en_<?=$linha["feedbacks_id"]?>" style="width: 99%; height: 120px; font-family: Arial; font-size: 12px; line-height: 120%"><?=$linha["descricao_en"]?></textarea>
                        </td>
                        <td align="center" valign="middle">
                            <textarea name="desc_es_<?=$linha["feedbacks_id"]?>" style="width: 99%; height: 120px; font-family: Arial; font-size: 12px; line-height: 120%"><?=$linha["descricao_es"]?></textarea>
                        </td>
  
                    </tr>
                    <?
				}
				?>
				</table>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<p align="center"><input type="submit" value="Salvar Alterações" class="form_style" /></p>
            
            </form>
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
<?if ($frase) {
	alert($frase);
}?>
</html>